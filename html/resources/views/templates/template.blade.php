<!DOCTYPE html>
<!--  Author: Daniel Kennedy  -->
<html>
<head>
	<!--Title-->
	<title>@yield('title')</title>
	<!--Browser Stuff-->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Search Tags-->
	<meta content="Leaving Certificate, Junior Certificate, and Leaving Certificate Applied examination material. Sorted." name="description">
	<meta content="index, follow" name="robots">
	<!--Favicons, etc-->
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!--Bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	 <style>
		 h1{
			 margin:0px;
		 }
	 </style>
	 @yield('header-stuff')
</head>
<body>
<!--Navbar-->
<ul class="nav nav-tabs justify-content-center">
  <li class="nav-item">
    <a class="nav-link" href="/">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/contact/">Contact</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/poster/">Poster</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/tc/">Terms & Conditions</a>
  </li>
		@Auth
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Account</a>
			<div class="dropdown-menu">
				<p class="dropdown-item">
					{{Auth::user()->name}}
				</p>
				<div class="dropdown-divider"></div>

				<a class="dropdown-item" href="{{ route("logout") }}"
				onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					Logout
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</div>
		</li>
		@else
		<li class="nav-item">
			<a class="nav-link" href="{{route("login")}}">Log in</a>
		</li>
		@endauth
</ul>
@yield('content')
</body>
</html>