<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<title>Disburse</title>
		<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
		<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		
		<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

	</head>
	<body>
		<div id="main" class="container-fluid vertical-center">

	        @yield('content')
	        
	    </div>
	    @yield('js')
	</body>
</html>