<aside class="left-side sidebar-offcanvas">
	<section class="sidebar">
		<!-- User -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo htmlspecialchars($relative_url); ?>assets/images/user.png" class="img-circle" alt="User Image" />
			</div>
			<div class="pull-left info">
				<p>Hello, <?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['name']) : ''; ?></p>
			</div>
		</div>

		<!-- Menu -->
		<ul class="sidebar-menu">
			<li <?php echo ($page == 'homepage') ? 'class="active"' : ''; ?>>
				<a href="<?php echo htmlspecialchars($relative_path); ?>index.php">
					<i class="fa fa-plug"></i> <span>Facebook Connection</span>
				</a>
			</li>

			<li <?php echo ($page == 'settings') ? 'class="active"' : ''; ?>>
				<a href="<?php echo htmlspecialchars($relative_path); ?>settings.php">
					<i class="fa fa-cog"></i> <span>Settings</span>
				</a>
			</li>

			<li <?php echo ($page == 'user') ? 'class="active"' : ''; ?>>
				<a href="<?php echo htmlspecialchars($relative_path); ?>user/list.php">
					<i class="fa fa-user"></i> <span>Users</span>
				</a>
			</li>
		</ul>
	</section>
</aside>
