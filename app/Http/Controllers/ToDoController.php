<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Task;
use App\User;
use App\Invitation;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Auth::user()->is_admin)
        {

           $coworkers = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 1)->get();
           $invitations = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 0)->get();
           $tasks = Task::where('user_id', Auth::user()->id)->orWhere('admin_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(4); 
        }

        else
        {

        $invitations = [];    
        $tasks = Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(4); 
        $coworkers = User::where('is_admin', 1)->get();
        
        }
        return view('tasks.index', compact('tasks', 'coworkers', 'invitations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        

        if($request->input('task')) {
            $task = new Task;
            $task->content = $request->input('task');
            $task->description = $request->input('task-desc');
            
            $task->due = $request->input('name');
            

            if (Auth::user()->is_admin)
            {
                if($request->input('assignTo') == Auth::user()->id)
                {
                    Auth::user()->tasks()->save($task);
                }
                elseif($request->input('assignTo') != null)
                {
                    $task->user_id = $request->input('assignTo');
                    $task->admin_id = Auth::user()->id;
                    $task->save();
                }
            }

            else 
            {
            Auth::user()->tasks()->save($task);
                
            }
        }
        
        return redirect()->back()->with('success', 'You created a task.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


      $task = Task::find($id);
      if(Auth::user()->is_admin)
      {
        $coworkers = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 1)->get();
        $invitations = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 0)->get();
            
      }
   
      else 
      {
        $coworkers = [];
        $invitations = [];
           
      }

     return view('tasks.edit', ['task'=>$task, 'coworkers'=>$coworkers, 'invitations' =>$invitations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {


        if ($request->input('task')) 
        {
            $task = Task::find($id);
            $task->content = $request->input('task');
            $task->description = $request->input('task-desc');
            $task->due = $request->input('name');
            

            

            if(Auth::user()->is_admin)
            {
                if($request->input('assignTo') == Auth::user()->id)
                {
                    Auth::user()->tasks()->save($task);
                }
                elseif ($request->input('assignTo') != null) 
                {
                    $task->user_id = $request->input('assignTo');
                    $task->admin_id = Auth::user()->id;
                    $task->save();
                }
            }
            else 
            {
            if($this->_authorize($task->user_id))
            $task->save();    
            }
            
        }
        return redirect('/')->with('success', 'You updated a task.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if(!Auth::user()->is_admin)
        {
            if(!$this->_authorize($task->user_id))
            {
                return redirect()->back()->with('success', 'Task Deleted');
                exit();
            }
             
        }
       
        $task->delete();
        return redirect()->back()->with('success', 'Task Deleted');
    }

    public function updateStatus($id) 
    {
        $task = Task::find($id);
        $task->status = ! $task->status;
        if($this->_authorize($task->user_id))
        $task->save();
        return redirect()->back()->with('success', 'Task Completed');
    }

    public function sendInvitation(Request $request)
    {
        if ((int) $request->input('admin') > 0
            && !Invitation::where('worker_id', Auth::user()->id)->where('admin_id', $request->input('admin'))->exists()
        ) 
        {
            $invitation = new Invitation;
            $invitation->worker_id = Auth::user()->id;
            $invitation->admin_id = (int) $request->input('admin');
            $invitation->save();


        }
        return redirect()->back()->with('success', 'Invite Sent');
    }

    public function acceptInvitation($id)
    {
        $invitation = Invitation::find($id);
        $invitation->accepted = true;
        if($this->_authorize($invitation->admin_id))
        $invitation->save();

        return redirect()->back()->with('success', 'You accepted the invitation');
    }

    public function denyInvitation($id)
    {
        $invitation = Invitation::find($id);
        if($this->_authorize($invitation->admin_id))
        $invitation->delete();
        return redirect()->back()->with('success', 'You declined the invitation');
    }

    public function deleteWorker($id)
    {
        $invitation = Invitation::find($id);
        if($this->_authorize($invitation->admin_id))
        $invitation->delete();
        return redirect()->back()->with('success', 'You deleted a team member');
    }

    protected function _authorize($id)
    {
        return Auth::user()->id === $id ? true : false;
    }
}
