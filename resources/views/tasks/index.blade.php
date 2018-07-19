@extends('layouts.master')

@section('content')

<div class="index-body">

	<div class="row">
		<div class="col-md-8 left-side">
			<table class="table table-hover">
				<thead class="thead-light">
				    <tr class="text-center">
				      <th scope="col">Task</th>
				      <th scope="col">Description</th>
				      <th scope="col">Due Date</th>


				      @isAdmin
				      <th scope="col">Assigned To</th>
				      @endisAdmin

				      <th scope="col">Edit</th>
				      <th scope="col">Delete</th>
				    </tr>
				</thead>
				<tbody>
					@foreach($tasks as $task)
				    <tr>
				      <td><a href="{{ route('updateStatus', $task->id) }}"> 

				      	@if(!$task->status)
				      	<p class="task-name">{{ $task->content }}</p>

				      	@else
				      	<s class="grey-text"> {{ $task->content }} </s>

				      	@endif
				      </a></td>
				      <td>
				      	<p class="task-name"> {{ $task->description }} </p>
				      </td>
				      <td class="text-center">
				      	<p class="task-name"> {{ $task->due }} </p>
				      </td>
				      @isAdmin
				      <td class="text-center">{{ $task->user->name }}</td>
				      @endisAdmin
				      <td class="text-center">
				      	<a title="edit" data-toggle="modal" href=" #{{ $task->id }} "><i class="fa fa-edit"></i></a>
				      </td>
				      <td class="text-center">
				      	<a title="destroy" onclick="return confirm('Delete?');" href="{{ route('destroy', $task->id)}}"><i class="fa fa-trash-alt"></i></a>
				      </td>
				    </tr>

				    <!-- Modal -->
					<div class="modal fade" id="{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h3 class="modal-title" id="exampleModalLabel"><b class="deny">Edit Task</b></h3>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">

					      	{!! Form:: open(['action' => ['ToDoController@update', $task->id], 'method' => 'POST', 'class' => 'sm-12']) !!}

								<div class="form-group">
									{{Form::text('task', $task->content, ['class' => 'validate form-control'])}}
								</div>

								<div class="form-group">
									{{Form::text('task-desc', $task->description, ['class' => 'validate form-control'])}}
								</div>

								<div class="form-group">
									{{Form::date('name', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
								</div>

								<div class="form-group">
									@include('partials.coworkers')
								</div>
								

								<!-- {{Form::hidden('_method', 'PUT')}} -->

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									{{Form::submit('Save Changes', ['class' => 'btn btn-primary'])}}
								</div>

								
							
							{!! Form::close() !!}
						</div>
					  </div>
					</div>

				    
				    @endforeach
				</tbody>
			</table>

	{{ $tasks->links() }}
		</div>

		<div class="col-md-4 right-side">

			{!! Form:: open(['action' => 'ToDoController@store', 'method' => 'POST', 'class' => 'sm-12']) !!}

				<div class="form-group">
					<h3><b>{{Form::label('task', 'New Task')}}</b></h3>
				</div>

				<div class="form-group">
					{{Form::text('task', '', ['class' => 'validate form-control', 'placeholder' => 'Add New Task'])}}
				</div>

				<div class="form-group">
					{{Form::text('task-desc', '', ['class' => 'validate form-control', 'placeholder' => 'What is this task about?'])}}
				</div>

				<div class="form-group">
					{{Form::date('name', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
				</div>

				<div class="form-group">
					@include('partials.coworkers')
				</div>
				

				<div class="form-group">
					{{Form::submit('Add New Task', ['class' => 'btn btn-primary'])}}
				</div>
			
			{!! Form::close() !!}

			<!-- <form method="POST" action="{{ route('store') }}" class="sm-12">
			  
				<div class="form-group">
				    <label for="task"><h3><b>New Task</b></h3></label>
				    <input name="task" type="text" class="validate form-control" id="task" placeholder="Add New Task">
				    <br>
				    <input name="task-desc" type="text" class="validate form-control" id="task-due" placeholder="Add  Task Description">
				    <br>
				    <input name="date" type="text" class="datepicker validate form-control" id="datepicker" >
				</div>
			  
			  @include('partials.coworkers')
			  <br>
			  <button type="submit" class="btn btn-primary">Add New Task</button>

			  @csrf
			</form> -->

			<hr>

			@isWorker
			<form action="{{ route('sendInvitation') }}" method="POST" class="sm-12">
				<div class="form-group">
					<label for="task"><h3><b>Send Invite</b></h3></label>
					<select class="form-control col-sm-12" name="admin">
						<option value="" disabled selected>Send Invitation to</option>
					  	@foreach($coworkers as $coworker)	
					  	<option value="{{ $coworker->id }}">{{ $coworker->name }}</option>
					  	@endforeach
					</select>
					<br>
			  		<button type="submit" class="btn btn-primary">Send Invitation</button>
				@csrf
				</div>
			</form>
			@endisWorker


			@isAdmin
			<table class="table table-hover">
				<thead>
				    <tr>
				      <th scope="col">MY COWORKERS</th>
				      <th scope="col">Action</th>
				    </tr>
				</thead>
				<tbody>
					@foreach($coworkers as $coworker)
					<tr>
				      <td>{{ $coworker->worker->name  }}</td>
				      <td><a title="delete" href=" {{ route('deleteWorker', $coworker->id)  }} "><i class="fa fa-trash-alt"></i></a></td>
				    </tr>
					@endforeach
				    

				    
				</tbody>
			</table>
			@endisAdmin

		</div>
	</div>
</div>

@endsection