<?php
include_once('config/database.php');

function fb_facebook_events_calendar() {
	// Get settings
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT * FROM settings where id = 1';
	$q = $pdo->prepare($sql);
	$q->execute();
	$settings = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();

	$events_layout 			= $settings ? $settings['events_layout'] : 'full';
	$events_initial_view 	= $settings ? $settings['events_initial_view'] : 'calendar';
	$events_start_date 		= $settings ? $settings['events_start_date'] : 'sunday';
	$events_switch_button 	= $settings ? $settings['events_switch_button'] : 'show';
	$events_list_filter 	= $settings ? $settings['events_list_filter'] : 'all';
	$events_show_title 		= $settings ? $settings['events_show_title'] : 'show';
	$events_num_items 		= $settings ? $settings['events_num_items'] : 1000;
	$events_time_format 	= $settings ? $settings['events_time_format'] : '24';
	$events_date_format 	= $settings ? $settings['events_date_format'] : 'l, d F Y';
	?>

	<div class="fb-facebook-all-in-one">
		<div class="facebook-events-calendar <?php echo htmlspecialchars($events_layout); ?>" data-view="<?php echo htmlspecialchars($events_initial_view); ?>" data-start="<?php echo htmlspecialchars($events_start_date); ?>" data-switch="<?php echo htmlspecialchars($events_switch_button); ?>" data-list="<?php echo htmlspecialchars($events_list_filter); ?>" data-title="<?php echo htmlspecialchars($events_show_title); ?>" data-events="<?php echo htmlspecialchars($events_num_items); ?>" data-time="<?php echo htmlspecialchars($events_time_format); ?>" data-date="<?php echo htmlspecialchars($events_date_format); ?>"></div>
	</div>
<?php
}
