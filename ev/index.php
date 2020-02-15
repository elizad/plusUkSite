<?php
include_once('component-events-calendar.php');
include_once('component-feed.php');
include_once('component-messenger.php');
include_once('component-likebox.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PLUS+ Filiala regatul unit</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="description" content="PLUS+ Filiala regatul unit">
        <meta name="keywords" content="PLUS+ Filiala regatul unit">

		<link rel='stylesheet' href='//fonts.googleapis.com/css?family=Raleway:400,500,600,700,300,100,800,900' type='text/css' media='all' />
		<link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' type='text/css' media='all' />

		<!-- Include CSS files -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/magnific-popup.css">
		<link rel="stylesheet" href="assets/css/main.css">

		<!-- Include JS files -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.magnific-popup.js"></script>
		<script src="assets/js/mediaelement.min.js"></script>
		<script src="assets/js/imagesloaded.pkgd.min.js"></script>
		<script src="assets/js/masonry.pkgd.min.js"></script>
		<script src="assets/languages/lang.js"></script>
		<script src="assets/js/calendar.js"></script>
		<script src="assets/js/main.js"></script>

		<!-- Demo file -->
		<link rel="stylesheet" href="assets/css/demo.css">
		<script src="assets/js/demo.js"></script>
	</head>

	<body>
		<div class="site">
			<div class="header-section">
				<header class="site-header header-fixed">
					<div class="container">
						<div class="site-branding">
							<div class="logo">
								<div class="site-logo">
									<a href="http://regatulunit.plus/index.html">
									PLUS+ UK
									</a>
								</div>
							</div>
						</div>
						<div class="header-right-wrapper">
							<a href="#0" id="nav-toggle">Menu<span></span></a>
							<nav id="site-navigation" class="main-navigation" role="navigation">
								<ul class="main-menu">
									<li class="menu-item"><a href="#events-calendar">Facebook Events Calendar</a></li>
									<li class="menu-item"><a href="#feed">Facebook Feed</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</header>
			</div>

			<div id="content" class="site-content">
				<section id="events-calendar" class="section background-1">
					<div class="container">
						<div class="section-title-area">
							<h5 class="section-subtitle">Facebook Events</h5>
							<h2 class="section-title">Events Calendar</h2>
						</div>

						<?php fb_facebook_events_calendar(); ?>
					</div>
				</section>

				<section id="feed" class="section background-2">
					<div class="container">
						<div class="section-title-area">
							<h5 class="section-subtitle">Posts, Photos and Albums</h5>
							<h2 class="section-title">Facebook Feed</h2>
						</div>

						<?php fb_facebook_feed(); ?>
					</div>
				</section>

				<?php fb_facebook_messenger(); ?>
				<?php fb_facebook_likebox(); ?>
			</div>

		    <footer class="site-footer">

		    </footer>
	   </div>
	</body>
</html>
