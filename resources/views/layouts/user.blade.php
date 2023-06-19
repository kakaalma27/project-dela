<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">

	<!-- JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <link href='/style/nav.css' rel='stylesheet'>
	<link href='/style/card.css' rel='stylesheet'>
	<link href='/style/piechart.css' rel='stylesheet'>

  </head>
  <body>
	<section id="sidebar">
		<a href="{{ route('home') }}" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Aplikasi Monitoring SPBE Kabupaten Tasikmalaya</span>
		</a>
		<ul class="side-menu top">
			<li class="{{ request()->is('user/dashboard*') ? 'active' : '' }}">
				<a href="{{ route('home') }}">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="{{ request()->is('user/create*') ? 'active' : '' }}">
				<a href="{{ route('create.data') }}">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Form Evidence</span>					
				</a>
			</li>
			<li class="{{ request()->is('user/data*') ? 'active' : '' }}">
				<a href="{{ route('data.user') }}">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Data Evidence</span>					
				</a>
			</li>
			<ul class="side-menu">
			</ul>
			<li>
				<a class="logout" href="{{ route('logout') }}"
				onclick="event.preventDefault();
					document.getElementById('logout-form').submit();">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
	
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</li>
		</ul>
	</section>
	
	<section id="content">
		<nav>
			<i class='bx bx-menu'></i>
			<form action="#" >
				<div class="form-input" hidden>
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="profile">
                {{ Auth::user()->name }}
			</a>
		</nav>
		<div class="main">
			@yield("main")
		</div>
	</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="/style/script.js"></script>
  </body>
</html>