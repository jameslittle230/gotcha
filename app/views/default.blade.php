<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="/styles/css/main.css">
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<header class="main-header">
			<h1 class="title">Gotcha</h1>

			<nav class="main-nav">
				<a class="main-nav__item {{ Request::path() == '/' ? 'main-nav__item--active' : '' }}" href="/" >Capture</a>
				<a class="main-nav__item {{ Request::path() == 'stats' ? 'main-nav__item--active' : '' }}" href="/stats">Statistics</a>
				<a class="main-nav__item {{ Request::path() == 'rules' ? 'main-nav__item--active' : '' }}" href="/rules">The Rules</a>
				<a class="main-nav__item {{ Request::path() == 'about' ? 'main-nav__item--active' : '' }}" href="/about">About</a>
				<a class="main-nav__item" href="/logout">Log Out</a>
			</nav>
		</header>

		@include('partials/flash')

		@yield('outside')

		<section class="game">
			
			<aside class="user-box">
				@if (!isset($hide_sidebar))
					@include('sidebar')
				@endif
			</aside>

			<section class="game-actions">
				@yield('content')

			</section>

		</section>

			
		<footer class="main-footer">
			<section class="copyright">
				<p>&copy; Copyright Milton Academy 2014</p>
			</section>
			<section class="credits">
				<p>Created by James Little, Class I<br>james_little15@milton.edu</p>
			</section>
		</footer>

		<script type="text/javascript">
			setTimeout(function(){fadeOutAlerts()}, 5000);

			function fadeOut(el) {
				el.style.opacity = 1;

				var last = +new Date();
				var tick = function() {
					el.style.opacity = +el.style.opacity - (new Date() - last) / 400;
					last = +new Date();

					if (+el.style.opacity > 0) {
						(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
					}
				};

				tick();
			}

			function fadeOutAlerts() {
				var alerts = document.querySelectorAll(".alert");
			
				for (var i = 0, length = alerts.length; i < length; i++) {
				 	console.log(alerts[i]);
				 	fadeOut(alerts[i]);
				 }
			}
		</script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-56574925-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>