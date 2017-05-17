<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			@hasSection('title')
				@yield('title') - Todo
			@else
				Todo
			@endif
		</title>
		<link rel="stylesheet" href="/css/base.css" />
		<link rel="stylesheet" href="/css/index.css" />
		<!-- CSS overrides - remove if you don't need it -->
		<link rel="stylesheet" href="/css/app.css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
	</head>
	<body>
		<header class="main-header">
			Todos
		</header>
		
		<section>
			@yield('content')
		</section>
		
		<footer class="info">
			<p>Double-click to edit a todo</p>
			<!-- Remove the below line ↓ -->
			<p>Template by <a href="http://sindresorhus.com">Sindre Sorhus</a></p>
			<!-- Change this out with your name and url ↓ -->
			<p>Created by <a href="http://todomvc.com">you</a></p>
			<p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
			
			@if (Auth::check())
				<p><a href="{!!route('user/logout')!!}">Выйти</a></p>
			@endif
		</footer>
		
		<script type="text/javascript" data-main="/js/app" src="/js/libs/require.js"></script>
		@yield('scripts')
	</body>
</html>