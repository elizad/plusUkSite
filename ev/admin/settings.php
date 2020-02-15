<?php
include_once('../config/database.php');

session_start();

// Variables
$relative_url = '../';
$relative_path = '';
$page = 'settings';

$events_layout 			= 'full';
$events_year_range 		= 3;
$events_initial_view	= 'calendar';
$events_start_date 		= 'sunday';
$events_switch_button 	= 'show';
$events_list_filter 	= 'all';
$events_show_title		= 'show';
$events_num_items 		= 1000;
$events_time_format 	= '24';
$events_date_format 	= 'l, d F Y';

$feed_year_range 		= 3;
$feed_initial_view 		= 'post';
$feed_switch_button		= 'show';
$feed_readmore_button 	= 'show';
$feed_num_items 		= 9;
$feed_date_format 		= 'F d, Y';

$messenger_language 	= 'en_US';
$messenger_mobile		= 0;
$messenger_position 	= 'right';
$messenger_hello 		= '';

$likebox_language		= 'en_US';
$likebox_mobile 		= 0;
$likebox_width 			= 300;
$likebox_height 		= 400;
$likebox_tab_timeline 	= 0;
$likebox_tab_events 	= 0;
$likebox_tab_messages 	= 0;
$likebox_position 		= 'right';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get info from database
$sql = 'SELECT * FROM settings where id = 1';
$q = $pdo->prepare($sql);
$q->execute();
$settings = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

if ($settings) {
	$events_layout 			= $settings['events_layout'];
	$events_year_range		= $settings['events_year_range'];
	$events_initial_view 	= $settings['events_initial_view'];
	$events_start_date 		= $settings['events_start_date'];
	$events_switch_button 	= $settings['events_switch_button'];
	$events_list_filter 	= $settings['events_list_filter'];
	$events_show_title		= $settings['events_show_title'];
	$events_num_items 		= $settings['events_num_items'];
	$events_time_format 	= $settings['events_time_format'];
	$events_date_format 	= $settings['events_date_format'];

	$feed_year_range 		= $settings['feed_year_range'];
	$feed_initial_view		= $settings['feed_initial_view'];
	$feed_switch_button 	= $settings['feed_switch_button'];
	$feed_readmore_button 	= $settings['feed_readmore_button'];
	$feed_num_items 		= $settings['feed_num_items'];
	$feed_date_format 		= $settings['feed_date_format'];

	$messenger_language 	= $settings['messenger_language'];
	$messenger_mobile		= $settings['messenger_mobile'];
	$messenger_position 	= $settings['messenger_position'];
	$messenger_hello 		= $settings['messenger_hello'];

	$likebox_language		= $settings['likebox_language'];
	$likebox_mobile 		= $settings['likebox_mobile'];
	$likebox_width 			= $settings['likebox_width'];
	$likebox_height 		= $settings['likebox_height'];
	$likebox_tab_timeline 	= $settings['likebox_tab_timeline'];
	$likebox_tab_events		= $settings['likebox_tab_events'];
	$likebox_tab_messages 	= $settings['likebox_tab_messages'];
	$likebox_position 		= $settings['likebox_position'];
}

// Save info on database
if (isset($_POST['save'])) {
	$events_layout 			= $_POST['events_layout'];
	$events_year_range		= $_POST['events_year_range'];
	$events_initial_view 	= $_POST['events_initial_view'];
	$events_start_date 		= $_POST['events_start_date'];
	$events_switch_button 	= $_POST['events_switch_button'];
	$events_list_filter 	= $_POST['events_list_filter'];
	$events_show_title		= $_POST['events_show_title'];
	$events_num_items 		= $_POST['events_num_items'];
	$events_time_format 	= $_POST['events_time_format'];
	$events_date_format 	= $_POST['events_date_format'];

	$feed_year_range 		= $_POST['feed_year_range'];
	$feed_initial_view		= $_POST['feed_initial_view'];
	$feed_switch_button 	= $_POST['feed_switch_button'];
	$feed_readmore_button 	= $_POST['feed_readmore_button'];
	$feed_num_items 		= $_POST['feed_num_items'];
	$feed_date_format 		= $_POST['feed_date_format'];

	$messenger_language 	= $_POST['messenger_language'];
	$messenger_mobile		= $_POST['messenger_mobile'];
	$messenger_position 	= $_POST['messenger_position'];
	$messenger_hello 		= $_POST['messenger_hello'];

	$likebox_language		= $_POST['likebox_language'];
	$likebox_mobile 		= $_POST['likebox_mobile'];
	$likebox_width 			= $_POST['likebox_width'];
	$likebox_height 		= $_POST['likebox_height'];
	$likebox_tab_timeline 	= isset($_POST['likebox_tab']['timeline']) ? $_POST['likebox_tab']['timeline'] : 0;
	$likebox_tab_events		= isset($_POST['likebox_tab']['events']) ? $_POST['likebox_tab']['events'] : 0;
	$likebox_tab_messages 	= isset($_POST['likebox_tab']['messages']) ? $_POST['likebox_tab']['messages'] : 0;
	$likebox_position 		= $_POST['likebox_position'];

	$sql = "UPDATE settings SET events_layout = ?, events_year_range = ?, events_initial_view = ?, events_start_date = ?, events_switch_button = ?, events_list_filter = ?, events_show_title = ?, events_num_items = ?, events_time_format = ?, events_date_format = ?, feed_year_range = ?, feed_initial_view = ?, feed_switch_button = ?, feed_readmore_button = ?, feed_num_items = ?, feed_date_format = ?, messenger_language = ?, messenger_mobile = ?, messenger_position = ?, messenger_hello = ?, likebox_language = ?, likebox_mobile = ?, likebox_width = ?, likebox_height = ?, likebox_tab_timeline = ?, likebox_tab_events = ?, likebox_tab_messages = ?, likebox_position = ? WHERE id = 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($events_layout, $events_year_range, $events_initial_view, $events_start_date, $events_switch_button, $events_list_filter, $events_show_title, $events_num_items, $events_time_format, $events_date_format, $feed_year_range, $feed_initial_view, $feed_switch_button, $feed_readmore_button, $feed_num_items, $feed_date_format, $messenger_language, $messenger_mobile, $messenger_position, $messenger_hello, $likebox_language, $likebox_mobile, $likebox_width, $likebox_height, $likebox_tab_timeline, $likebox_tab_events, $likebox_tab_messages, $likebox_position));
	Database::disconnect();
}
?>

<?php
ob_start();
?>

<!DOCTYPE html>
<html>
<!-- Header -->
<?php include $relative_path . 'header.php'; ?>

<?php if (empty($_SESSION['user'])) { // Not login ?>
	<?php include $relative_path . 'login.php'; ?>
<?php } else { ?>
	<body class="admin-panel">
		<!-- Navbar -->
		<?php include $relative_path . 'navbar.php'; ?>

		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- Sidebar -->
			<?php include $relative_path . 'sidebar.php'; ?>

			<aside class="right-side">
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<form class="form-horizontal" action="settings.php" method="post">
								<section class="panel">
									<header class="panel-heading">Facebook Events Calendar</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Layout</label>
											<div class="col-sm-8">
												<select name="events_layout" class="form-control">
													<option <?php if ($events_layout == 'full') echo 'selected="selected"'; ?> value="full">Full</option>
													<option <?php if ($events_layout == 'compact') echo 'selected="selected"'; ?> value="compact">Compact</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Year Range</label>
											<div class="col-sm-8">
												<input type="text" name="events_year_range" class="form-control" value="<?php echo htmlspecialchars($events_year_range); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Initial View</label>
											<div class="col-sm-8">
												<select name="events_initial_view" class="form-control">
													<option <?php if ($events_initial_view == 'calendar') echo 'selected="selected"'; ?> value="calendar">Calendar</option>
													<option <?php if ($events_initial_view == 'list') echo 'selected="selected"'; ?> value="list">Event List</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Start Date</label>
											<div class="col-sm-8">
												<select name="events_start_date" class="form-control">
													<option <?php if ($events_start_date == 'sunday') echo 'selected="selected"'; ?> value="sunday">Sunday</option>
													<option <?php if ($events_start_date == 'monday') echo 'selected="selected"'; ?> value="monday">Monday</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Switch Button</label>
											<div class="col-sm-8">
												<select name="events_switch_button" class="form-control">
													<option <?php if ($events_switch_button == 'show') echo 'selected="selected"'; ?> value="show">Show</option>
													<option <?php if ($events_switch_button == 'hide') echo 'selected="selected"'; ?> value="hide">Hide</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Events List Count</label>
											<div class="col-sm-8">
												<input type="text" name="events_num_items" class="form-control" value="<?php echo htmlspecialchars($events_num_items); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Events List Filter</label>
											<div class="col-sm-8">
												<select name="events_list_filter" class="form-control">
													<option <?php if ($events_list_filter == 'all') echo 'selected="selected"'; ?> value="all">All Events</option>
													<option <?php if ($events_list_filter == 'upcoming') echo 'selected="selected"'; ?> value="upcoming">Upcoming Events</option>
													<option <?php if ($events_list_filter == 'past') echo 'selected="selected"'; ?> value="past">Past Events</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Events List Filter Title</label>
											<div class="col-sm-8">
												<select name="events_show_title" class="form-control">
													<option <?php if ($events_show_title == 'show') echo 'selected="selected"'; ?> value="show">Show</option>
													<option <?php if ($events_show_title == 'hide') echo 'selected="selected"'; ?> value="hide">Hide</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Time Format</label>
											<div class="col-sm-8">
												<select name="events_time_format" class="form-control">
													<option <?php if ($events_time_format == '12') echo 'selected="selected"'; ?> value="12">12h</option>
													<option <?php if ($events_time_format == '24') echo 'selected="selected"'; ?> value="24">24h</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Date Format</label>
											<div class="col-sm-8">
												<input type="text" name="events_date_format" class="form-control" value="<?php echo htmlspecialchars($events_date_format); ?>">
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-8">
												<button name="save" type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save</button>
											</div>
										</div>
									</div>
								</section>

								<section class="panel">
									<header class="panel-heading">Facebook Feed</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Year Range</label>
											<div class="col-sm-8">
												<input type="text" name="feed_year_range" class="form-control" value="<?php echo htmlspecialchars($feed_year_range); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Initial View</label>
											<div class="col-sm-8">
												<select name="feed_initial_view" class="form-control">
													<option <?php if ($feed_initial_view == 'post') echo 'selected="selected"'; ?> value="post">Post</option>
													<option <?php if ($feed_initial_view == 'photo') echo 'selected="selected"'; ?> value="photo">Photo</option>
													<option <?php if ($feed_initial_view == 'album') echo 'selected="selected"'; ?> value="album">Album</option>
													<option <?php if ($feed_initial_view == 'video') echo 'selected="selected"'; ?> value="video">Video</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Switch button</label>
											<div class="col-sm-8">
												<select name="feed_switch_button" class="form-control">
													<option <?php if ($feed_switch_button == 'show') echo 'selected="selected"'; ?> value="show">Show</option>
													<option <?php if ($feed_switch_button == 'hide') echo 'selected="selected"'; ?> value="hide">Hide</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Read More button</label>
											<div class="col-sm-8">
												<select name="feed_readmore_button" class="form-control">
													<option <?php if ($feed_readmore_button == 'show') echo 'selected="selected"'; ?> value="show">Show</option>
													<option <?php if ($feed_readmore_button == 'hide') echo 'selected="selected"'; ?> value="hide">Hide</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Number of items</label>
											<div class="col-sm-8">
												<input type="text" name="feed_num_items" class="form-control" value="<?php echo htmlspecialchars($feed_num_items); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Date Format</label>
											<div class="col-sm-8">
												<input type="text" name="feed_date_format" class="form-control" value="<?php echo htmlspecialchars($feed_date_format); ?>">
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-8">
												<button name="save" type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save</button>
											</div>
										</div>
									</div>
								</section>

								<section class="panel">
									<header class="panel-heading">Facebook Messenger</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Language</label>
											<div class="col-sm-8">
												<select name="messenger_language" class="form-control">
													<option <?php if ($messenger_language == 'af_ZA') echo 'selected="selected"'; ?> value="af_ZA">Afrikaans (SouthAfrica)</option>
													<option <?php if ($messenger_language == 'af_AF') echo 'selected="selected"'; ?> value="af_AF">Afrikaans</option>
													<option <?php if ($messenger_language == 'ar_AR') echo 'selected="selected"'; ?> value="ar_AR">Arabic</option>
													<option <?php if ($messenger_language == 'bn_IN') echo 'selected="selected"'; ?> value="bn_IN">Bengali</option>
													<option <?php if ($messenger_language == 'my_MM') echo 'selected="selected"'; ?> value="my_MM">Burmese</option>
													<option <?php if ($messenger_language == 'zh_CN') echo 'selected="selected"'; ?> value="zh_CN">Chinese (China)</option>
													<option <?php if ($messenger_language == 'zh_HK') echo 'selected="selected"'; ?> value="zh_HK">Chinese (HongKong)</option>
													<option <?php if ($messenger_language == 'zh_TW') echo 'selected="selected"'; ?> value="zh_TW">Chinese (Taiwan)</option>
													<option <?php if ($messenger_language == 'hr_HR') echo 'selected="selected"'; ?> value="hr_HR">Croatian</option>
													<option <?php if ($messenger_language == 'cs_CZ') echo 'selected="selected"'; ?> value="cs_CZ">Czech</option>
													<option <?php if ($messenger_language == 'da_DK') echo 'selected="selected"'; ?> value="da_DK">Danish</option>
													<option <?php if ($messenger_language == 'nl_NL') echo 'selected="selected"'; ?> value="nl_NL">Dutch</option>
													<option <?php if ($messenger_language == 'en_GB') echo 'selected="selected"'; ?> value="en_GB">English (UnitedKingdom)</option>
													<option <?php if ($messenger_language == 'en_US') echo 'selected="selected"'; ?> value="en_US">English</option>
													<option <?php if ($messenger_language == 'fi_FI') echo 'selected="selected"'; ?> value="fi_FI">Finnish</option>
													<option <?php if ($messenger_language == 'fr_FR') echo 'selected="selected"'; ?> value="fr_FR">French</option>
													<option <?php if ($messenger_language == 'de_DE') echo 'selected="selected"'; ?> value="de_DE">German</option>
													<option <?php if ($messenger_language == 'el_GR') echo 'selected="selected"'; ?> value="el_GR">Greek</option>
													<option <?php if ($messenger_language == 'gu_IN') echo 'selected="selected"'; ?> value="gu_IN">Gujarati</option>
													<option <?php if ($messenger_language == 'he_IL') echo 'selected="selected"'; ?> value="he_IL">Hebrew</option>
													<option <?php if ($messenger_language == 'hi_IN') echo 'selected="selected"'; ?> value="hi_IN">Hindi</option>
													<option <?php if ($messenger_language == 'hu_HU') echo 'selected="selected"'; ?> value="hu_HU">Hungarian</option>
													<option <?php if ($messenger_language == 'id_ID') echo 'selected="selected"'; ?> value="id_ID">Indonesian</option>
													<option <?php if ($messenger_language == 'it_IT') echo 'selected="selected"'; ?> value="it_IT">Italian</option>
													<option <?php if ($messenger_language == 'ja_JP') echo 'selected="selected"'; ?> value="ja_JP">Japanese</option>
													<option <?php if ($messenger_language == 'ko_KR') echo 'selected="selected"'; ?> value="ko_KR">Korean</option>
													<option <?php if ($messenger_language == 'cb_IQ') echo 'selected="selected"'; ?> value="cb_IQ">Kurdish</option>
													<option <?php if ($messenger_language == 'ms_MY') echo 'selected="selected"'; ?> value="ms_MY">Malay</option>
													<option <?php if ($messenger_language == 'ml_IN') echo 'selected="selected"'; ?> value="ml_IN">Malayalam</option>
													<option <?php if ($messenger_language == 'mr_IN') echo 'selected="selected"'; ?> value="mr_IN">Marathi</option>
													<option <?php if ($messenger_language == 'nb_NO') echo 'selected="selected"'; ?> value="nb_NO">Norwegian</option>
													<option <?php if ($messenger_language == 'pl_PL') echo 'selected="selected"'; ?> value="pl_PL">Polish</option>
													<option <?php if ($messenger_language == 'pt_BR') echo 'selected="selected"'; ?> value="pt_BR">Portuguese (Brazil)</option>
													<option <?php if ($messenger_language == 'pt_PT') echo 'selected="selected"'; ?> value="pt_PT">Portuguese</option>
													<option <?php if ($messenger_language == 'pa_IN') echo 'selected="selected"'; ?> value="pa_IN">Punjabi</option>
													<option <?php if ($messenger_language == 'ro_RO') echo 'selected="selected"'; ?> value="ro_RO">Romanian</option>
													<option <?php if ($messenger_language == 'ru_RU') echo 'selected="selected"'; ?> value="ru_RU">Russian</option>
													<option <?php if ($messenger_language == 'sk_SK') echo 'selected="selected"'; ?> value="sk_SK">Slovak</option>
													<option <?php if ($messenger_language == 'es_LA') echo 'selected="selected"'; ?> value="es_LA">Spanish (LatinAmerica)</option>
													<option <?php if ($messenger_language == 'es_ES') echo 'selected="selected"'; ?> value="es_ES">Spanish</option>
													<option <?php if ($messenger_language == 'sw_KE') echo 'selected="selected"'; ?> value="sw_KE">Swahili</option>
													<option <?php if ($messenger_language == 'sv_SE') echo 'selected="selected"'; ?> value="sv_SE">Swedish</option>
													<option <?php if ($messenger_language == 'tl_PH') echo 'selected="selected"'; ?> value="tl_PH">Tagalog</option>
													<option <?php if ($messenger_language == 'ta_IN') echo 'selected="selected"'; ?> value="ta_IN">Tamil</option>
													<option <?php if ($messenger_language == 'te_IN') echo 'selected="selected"'; ?> value="te_IN">Telugu</option>
													<option <?php if ($messenger_language == 'th_TH') echo 'selected="selected"'; ?> value="th_TH">Thai</option>
													<option <?php if ($messenger_language == 'tr_TR') echo 'selected="selected"'; ?> value="tr_TR">Turkish</option>
													<option <?php if ($messenger_language == 'ur_PK') echo 'selected="selected"'; ?> value="ur_PK">Urdu</option>
													<option <?php if ($messenger_language == 'vi_VN') echo 'selected="selected"'; ?> value="vi_VN">Vietnamese</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Hide on mobile</label>
											<div class="col-sm-8">
												<select name="messenger_mobile" class="form-control">
													<option <?php if ($messenger_mobile == 1) echo 'selected="selected"'; ?> value="1">Yes</option>
													<option <?php if ($messenger_mobile == 0) echo 'selected="selected"'; ?> value="0">No</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Position on the page</label>
											<div class="col-sm-8">
												<select name="messenger_position" class="form-control">
													<option <?php if ($messenger_position == 'right') echo 'selected="selected"'; ?> value="right">Right</option>
													<option <?php if ($messenger_position == 'left') echo 'selected="selected"'; ?> value="left">Left</option>
													<option <?php if ($messenger_position == 'center') echo 'selected="selected"'; ?> value="center">Center</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Greeting text</label>
											<div class="col-sm-8">
												<textarea name="messenger_hello" rows="4" cols="52"><?php echo htmlspecialchars($messenger_hello); ?></textarea>
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-8">
												<button name="save" type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save</button>
											</div>
										</div>
									</div>
								</section>

								<section class="panel">
									<header class="panel-heading">Facebook Likebox</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Language</label>
											<div class="col-sm-8">
												<select name="likebox_language" class="form-control">
													<option <?php if ($likebox_language == 'af_ZA') echo 'selected="selected"'; ?> value="af_ZA">Afrikaans (SouthAfrica)</option>
													<option <?php if ($likebox_language == 'af_AF') echo 'selected="selected"'; ?> value="af_AF">Afrikaans</option>
													<option <?php if ($likebox_language == 'ar_AR') echo 'selected="selected"'; ?> value="ar_AR">Arabic</option>
													<option <?php if ($likebox_language == 'bn_IN') echo 'selected="selected"'; ?> value="bn_IN">Bengali</option>
													<option <?php if ($likebox_language == 'my_MM') echo 'selected="selected"'; ?> value="my_MM">Burmese</option>
													<option <?php if ($likebox_language == 'zh_CN') echo 'selected="selected"'; ?> value="zh_CN">Chinese (China)</option>
													<option <?php if ($likebox_language == 'zh_HK') echo 'selected="selected"'; ?> value="zh_HK">Chinese (HongKong)</option>
													<option <?php if ($likebox_language == 'zh_TW') echo 'selected="selected"'; ?> value="zh_TW">Chinese (Taiwan)</option>
													<option <?php if ($likebox_language == 'hr_HR') echo 'selected="selected"'; ?> value="hr_HR">Croatian</option>
													<option <?php if ($likebox_language == 'cs_CZ') echo 'selected="selected"'; ?> value="cs_CZ">Czech</option>
													<option <?php if ($likebox_language == 'da_DK') echo 'selected="selected"'; ?> value="da_DK">Danish</option>
													<option <?php if ($likebox_language == 'nl_NL') echo 'selected="selected"'; ?> value="nl_NL">Dutch</option>
													<option <?php if ($likebox_language == 'en_GB') echo 'selected="selected"'; ?> value="en_GB">English (UnitedKingdom)</option>
													<option <?php if ($likebox_language == 'en_US') echo 'selected="selected"'; ?> value="en_US">English</option>
													<option <?php if ($likebox_language == 'fi_FI') echo 'selected="selected"'; ?> value="fi_FI">Finnish</option>
													<option <?php if ($likebox_language == 'fr_FR') echo 'selected="selected"'; ?> value="fr_FR">French</option>
													<option <?php if ($likebox_language == 'de_DE') echo 'selected="selected"'; ?> value="de_DE">German</option>
													<option <?php if ($likebox_language == 'el_GR') echo 'selected="selected"'; ?> value="el_GR">Greek</option>
													<option <?php if ($likebox_language == 'gu_IN') echo 'selected="selected"'; ?> value="gu_IN">Gujarati</option>
													<option <?php if ($likebox_language == 'he_IL') echo 'selected="selected"'; ?> value="he_IL">Hebrew</option>
													<option <?php if ($likebox_language == 'hi_IN') echo 'selected="selected"'; ?> value="hi_IN">Hindi</option>
													<option <?php if ($likebox_language == 'hu_HU') echo 'selected="selected"'; ?> value="hu_HU">Hungarian</option>
													<option <?php if ($likebox_language == 'id_ID') echo 'selected="selected"'; ?> value="id_ID">Indonesian</option>
													<option <?php if ($likebox_language == 'it_IT') echo 'selected="selected"'; ?> value="it_IT">Italian</option>
													<option <?php if ($likebox_language == 'ja_JP') echo 'selected="selected"'; ?> value="ja_JP">Japanese</option>
													<option <?php if ($likebox_language == 'ko_KR') echo 'selected="selected"'; ?> value="ko_KR">Korean</option>
													<option <?php if ($likebox_language == 'cb_IQ') echo 'selected="selected"'; ?> value="cb_IQ">Kurdish</option>
													<option <?php if ($likebox_language == 'ms_MY') echo 'selected="selected"'; ?> value="ms_MY">Malay</option>
													<option <?php if ($likebox_language == 'ml_IN') echo 'selected="selected"'; ?> value="ml_IN">Malayalam</option>
													<option <?php if ($likebox_language == 'mr_IN') echo 'selected="selected"'; ?> value="mr_IN">Marathi</option>
													<option <?php if ($likebox_language == 'nb_NO') echo 'selected="selected"'; ?> value="nb_NO">Norwegian</option>
													<option <?php if ($likebox_language == 'pl_PL') echo 'selected="selected"'; ?> value="pl_PL">Polish</option>
													<option <?php if ($likebox_language == 'pt_BR') echo 'selected="selected"'; ?> value="pt_BR">Portuguese (Brazil)</option>
													<option <?php if ($likebox_language == 'pt_PT') echo 'selected="selected"'; ?> value="pt_PT">Portuguese</option>
													<option <?php if ($likebox_language == 'pa_IN') echo 'selected="selected"'; ?> value="pa_IN">Punjabi</option>
													<option <?php if ($likebox_language == 'ro_RO') echo 'selected="selected"'; ?> value="ro_RO">Romanian</option>
													<option <?php if ($likebox_language == 'ru_RU') echo 'selected="selected"'; ?> value="ru_RU">Russian</option>
													<option <?php if ($likebox_language == 'sk_SK') echo 'selected="selected"'; ?> value="sk_SK">Slovak</option>
													<option <?php if ($likebox_language == 'es_LA') echo 'selected="selected"'; ?> value="es_LA">Spanish (LatinAmerica)</option>
													<option <?php if ($likebox_language == 'es_ES') echo 'selected="selected"'; ?> value="es_ES">Spanish</option>
													<option <?php if ($likebox_language == 'sw_KE') echo 'selected="selected"'; ?> value="sw_KE">Swahili</option>
													<option <?php if ($likebox_language == 'sv_SE') echo 'selected="selected"'; ?> value="sv_SE">Swedish</option>
													<option <?php if ($likebox_language == 'tl_PH') echo 'selected="selected"'; ?> value="tl_PH">Tagalog</option>
													<option <?php if ($likebox_language == 'ta_IN') echo 'selected="selected"'; ?> value="ta_IN">Tamil</option>
													<option <?php if ($likebox_language == 'te_IN') echo 'selected="selected"'; ?> value="te_IN">Telugu</option>
													<option <?php if ($likebox_language == 'th_TH') echo 'selected="selected"'; ?> value="th_TH">Thai</option>
													<option <?php if ($likebox_language == 'tr_TR') echo 'selected="selected"'; ?> value="tr_TR">Turkish</option>
													<option <?php if ($likebox_language == 'ur_PK') echo 'selected="selected"'; ?> value="ur_PK">Urdu</option>
													<option <?php if ($likebox_language == 'vi_VN') echo 'selected="selected"'; ?> value="vi_VN">Vietnamese</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Hide on mobile</label>
											<div class="col-sm-8">
												<select name="likebox_mobile" class="form-control">
													<option <?php if ($likebox_mobile == 1) echo 'selected="selected"'; ?> value="1">Yes</option>
													<option <?php if ($likebox_mobile == 0) echo 'selected="selected"'; ?> value="0">No</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Width (px)</label>
											<div class="col-sm-8">
												<input type="text" name="likebox_width" class="form-control" value="<?php echo htmlspecialchars($likebox_width); ?>" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Height (px)</label>
											<div class="col-sm-8">
												<input type="text" name="likebox_height" class="form-control" value="<?php echo htmlspecialchars($likebox_height); ?>" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Content</label>
											<div class="col-sm-8">
												<label class="check-item">
													<input type="checkbox" value="1" name="likebox_tab[timeline]" <?php if ($likebox_tab_timeline) echo 'checked'; ?>> Timeline <br>
												</label>
												<label class="check-item">
													<input type="checkbox" value="1" name="likebox_tab[events]" <?php if ($likebox_tab_events) echo 'checked'; ?>> Events <br>
												</label>
												<label class="check-item">
													<input type="checkbox" value="1" name="likebox_tab[messages]" <?php if ($likebox_tab_messages) echo 'checked'; ?>> Messages
												</label>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Position on the page</label>
											<div class="col-sm-8">
												<select name="likebox_position" class="form-control">
													<option <?php if ($likebox_position == 'right') echo 'selected="selected"'; ?> value="right">Right</option>
													<option <?php if ($likebox_position == 'left') echo 'selected="selected"'; ?> value="left">Left</option>
													<option <?php if ($likebox_position == 'popup') echo 'selected="selected"'; ?> value="popup">Popup</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-8">
												<button name="save" type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save</button>
											</div>
										</div>
									</div>
								</section>
							</form>
						</div>
					</div>
				</section>

				<!-- Footer -->
				<?php include $relative_path . 'footer.php'; ?>
			</aside>
		</div>
	</body>
<?php } ?>
</html>
