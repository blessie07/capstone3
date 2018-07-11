<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Project Plan</title>

    <!--FontAwesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Datepicker -->
    <script src="https://cdnjs.cloudfare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

  </head>
  <body>
    
    <div class="container">
    	<div class="row justify-content-between">
    		<nav class="navbar">
    			<a href="#" class="navbar-brand">Project List</a>
    		</nav>
    		<div class="wrapper-nav">
    			<form id="logout-form" action="{{ route('logout') }}" method="POST" >
			    @csrf
			    	<p>Logged as <b>{{ Auth::user()->name }}</b> <button type="submit" class="btn btn-outline-info  "> Log Out </button></p>
			    </form>
    		</div>
    	</div>		
	</div>
	    
    
    
    <div class="container-fluid">
   	@isAdmin
	   	<div class="invite-wrap">
		@if ($invitations->count()>0)
		    <div class="accordion" id="accordionExample">
				<div class="card">
				    <div class="card-header" id="headingOne">
					    <h5 class="mb-0">
				        	<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				        		<i class="fa fa-user-plus"></i>
				           			<span class="invite">Invitations</span> <span class="badge badge-success text-right"> {{ $invitations->count() }} </span>
				  					<span class="sr-only">unread messages</span>
				        	</button>
				      	</h5>
				    </div>

				    
				      	
				    @foreach($invitations as $invitation)

				    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">	
				      	<div class="card-body">
				        	<span> <b class="invite">{{ $invitation->worker->name }}</b><a href="{{ route('acceptInvitation', ['id' => $invitation->id])  }}"> accept</a> | <a href="{{ route('denyInvitation', ['id' => $invitation->id])  }}"> deny</a></span>
				      	</div>
				    </div>
				    @endforeach  	
				      	
				    
				    
				</div>
			</div> 
		</div>
		@endif
	@endisAdmin

		<h1 class="text-center"><b class="login-card">Project Plan</b></h1>
		
		<div class="error-wrap">
			@include('partials.errors')
		</div>
	
	@yield('content')

	</div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	$('.datepicker').datepicker({
    		autoclose: true,
    		format: 'dd/mm/yyyy'
    	});
    </script>
  </body>
</html>
