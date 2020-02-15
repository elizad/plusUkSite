<?php
include_once('config/database.php');

function curl_get_contents($url) {
	$ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Facebook connection
$sql = 'SELECT * FROM connection where id = 1';
$q = $pdo->prepare($sql);
$q->execute();
$connection = $q->fetch(PDO::FETCH_ASSOC);

// Settings
$sql = 'SELECT * FROM settings where id = 1';
$q = $pdo->prepare($sql);
$q->execute();
$settings = $q->fetch(PDO::FETCH_ASSOC);

Database::disconnect();

// Year range
$year_range = $settings ? $settings['events_year_range'] : 3;
$since_date = strtotime(date('Y-m-d', strtotime('-' . $year_range . ' years')));
$until_date = strtotime(date('Y-m-d', strtotime('+' . $year_range . ' years')));

$fb_page_id 	= $connection ? $connection['facebook_page'] : '';
$access_token 	= $connection ? $connection['access_token'] : '';

$fields = "id,name,description,place,timezone,start_time,end_time,cover,event_times";
$json_link = "https://graph.facebook.com/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since={$since_date}&until={$until_date}&limit=1000";
if (ini_get('allow_url_fopen')) {
	$json = file_get_contents($json_link);
} else {
	$json = curl_get_contents($json_link);
}

// Decode json from Facebook Graph API
$fb_events = json_decode($json, true);

// Convert data for json to use in ajax
$buf_event = array();
$buf_events = array();
$events = array();
if (count($fb_events['data']) > 0) {
	foreach ($fb_events['data'] as $fb_event) {
		if (isset($fb_event['event_times'])) {
			foreach ($fb_event['event_times'] as $child_event) {
				$buf_event['id'] 			= $fb_event['id'];
				$buf_event['name'] 			= $fb_event['name'];
				if (isset($fb_event['cover'])) {
					$buf_event['cover'] 		= $fb_event['cover'];
				}
				$buf_event['place'] 		= $fb_event['place'];
				if (isset($fb_event['timezone'])) {
					$buf_event['timezone'] 		= $fb_event['timezone'];
				}
				$buf_event['description'] 	= $fb_event['description'];
				$buf_event['start_time'] 	= $child_event['start_time'];
				$buf_event['end_time'] 		= $child_event['end_time'];

				array_push($buf_events, $buf_event);
			}
		} else {
			$buf_event = $fb_event;

			array_push($buf_events, $buf_event);
		}
	}

	foreach ($buf_events as $fb_event) {
		date_default_timezone_set($fb_event['timezone']);
		$event = new stdClass();
		$event->event_id = $fb_event['id'];
		$event->name = $fb_event['name'];
		$event->image = isset($fb_event['cover']['source']) ? $fb_event['cover']['source'] : "https://graph.facebook.com/{$fb_page_id}/picture?type=large";
		$event->day = date('j', strtotime($fb_event['start_time']));
		$event->month = date('n', strtotime($fb_event['start_time']));
		$event->year = date('Y', strtotime($fb_event['start_time']));
		$event->start_date = date($_POST['date_format'], strtotime($fb_event['start_time']));

		if ($_POST['time_format'] == '12') { // 12h format
			$event->time = $fb_event['start_time'] ? date('h:i a', strtotime($fb_event['start_time'])) : '';
			$event->end_time = isset($fb_event['end_time']) ? date('h:i a', strtotime($fb_event['end_time'])) : '';
		} else { // 24h format
			$event->time = $fb_event['start_time'] ? date('H:i', strtotime($fb_event['start_time'])) : '';
			$event->end_time = isset($fb_event['end_time']) ? date('H:i', strtotime($fb_event['end_time'])) : '';
		}

		// Duration
		if (!isset($fb_event['end_time'])) {
			$event->duration = 1; // If end_time is blank -> event's duration = 1 (day).
		} else {
			if (date('Ymd', strtotime($fb_event['start_time'])) == date('Ymd', strtotime($fb_event['end_time']))) { // If start date and end date are same day -> event's duration = 1 (day).
				$event->duration = 1;
			} else {
				$start_day = date('Y-m-d', strtotime($fb_event['start_time']));
				$end_day = date('Y-m-d', strtotime($fb_event['end_time']));
				$event->duration = round(abs(strtotime($end_day)-strtotime($start_day))/86400) + 1; // Get event's duration = days between start date and end date.
				$event->end_date = date($_POST['date_format'], strtotime($fb_event['end_time']));
			}
		}

		// Location
		$location_ar = array();
		if (isset($fb_event['place']['name'])) { array_push($location_ar, $fb_event['place']['name']); }
		if (isset($fb_event['place']['location']['city'])) { array_push($location_ar, $fb_event['place']['location']['city']); }
		if (isset($fb_event['place']['location']['country'])) { array_push($location_ar, $fb_event['place']['location']['country']); }
		if (isset($fb_event['place']['location']['zip'])) { array_push($location_ar, $fb_event['place']['location']['zip']); }
		$event->location = implode(", ", $location_ar);

		// Map
		if (isset($fb_event['place']['location']['latitude'])) { $event->latitude = $fb_event['place']['location']['latitude']; }
		if (isset($fb_event['place']['location']['longitude'])) { $event->longitude = $fb_event['place']['location']['longitude']; }

		if (isset($fb_event['description'])) {
			$event->intro = $fb_event['description'];
			$event->description = nl2br($fb_event['description']);
		}

		array_push($events, $event);
	}
}

echo json_encode($events);
?>
