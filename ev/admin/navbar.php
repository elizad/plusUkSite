<?php
// Check session login
if (empty($_SESSION['user'])) {
	// If not login, redirect to the index page
	header('Location: ' . $relative_path . 'index.php');
	EXIT;
} else {
	if (isset($_SESSION['login_time'])){
		$login_session_duration = 900; // 15 minutes
		$current_time = time();
		if (((time() - $_SESSION['login_time']) > $login_session_duration)) { // Timeover
			// Unset session
			unset($_SESSION['user']);
			unset($_SESSION['login_time']);

			// Redirect to the index page
			header('Location: ' . $relative_path . 'index.php');
			EXIT;
		} else {
			$_SESSION['login_time'] = time();
		}
	}
}

?>

<header class="header">
	<a href="<?php echo htmlspecialchars($relative_path); ?>index.php" class="logo"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Facebook Events</span></a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<li class="user user-menu">
					<a target="_blank" href="<?php echo htmlspecialchars($relative_url); ?>index.php">
						<i class="fa fa-home"></i> <span>Visit Site</span>
					</a>
				</li>
				<li class="user user-menu">
					<a href="<?php echo htmlspecialchars($relative_path) . 'logout.php'; ?>">
						<i class="fa fa-sign-out"></i> <span>Logout</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
