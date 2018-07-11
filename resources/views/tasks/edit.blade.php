@extends('layouts.master')

@section('content')
<form method="POST" action="{{ route('update', ['id'=>$task->id]) }}" class="sm-12">
	<div class="form-group">
		<label for="task">Edit Task</label>
		<input value="{{ $task->content }}" type="text" class="validate form-control" id="task2" name="task">
	</div>

	@include('partials.coworkers')
	<input type="hidden" name="PUT">
	<button type="submit" class="btn btn-primary">Edit Task</button>

	@csrf
</form>
@endsection