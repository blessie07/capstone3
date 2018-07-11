@isAdmin

<select class="form-control col-sm-12" name="assignTo">
	<option value="" disabled selected>Assign To:</option>
	<option value="{{ Auth::user()->id }}">To Myself</option>
		@foreach($coworkers as $coworker)
			@if(isset($task) && $coworker->worker->id == $task->user->id)			  		
	  		<option selected value="{{ $coworker->worker->id  }}"> {{ $coworker->worker->name  }} </option>
			@else	  		
			<option value="{{ $coworker->worker->id }}"> {{ $coworker->worker->name  }} </option>
			@endif		
		@endforeach
	</select>

@endisAdmin