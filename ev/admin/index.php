<?php
include_once('../config/database.php');
include_once('../assets/libraries/FacebookSDK/src/Facebook/autoload.php');

function file_get_contents_curl($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$result = curl_exec($ch);

	curl_close($ch);

	return $result;
}

session_start();

// Variables
$relative_url = '../';
$relative_path = '';
$page = 'homepage';

$app_id 		= '';
$secret 		= '';
$user_id 		= '';
$access_token 	= '';
$facebook_page	= '';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get info from database
$sql = 'SELECT * FROM connection where id = 1';
$q = $pdo->prepare($sql);
$q->execute();
$facebook_con = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

if ($facebook_con) {
	$app_id 		= $facebook_con['app_id'];
	$secret 		= $facebook_con['secret'];
	$user_id 		= $facebook_con['user_id'];
	$access_token 	= $facebook_con['access_token'];
	$facebook_page	= $facebook_con['facebook_page'];
}

// Save info on database
if (isset($_POST['app_id'])) {
	$app_id 		= $_POST['app_id'];
	$secret 		= $_POST['secret'];
	$facebook_page 	= isset($_POST['facebook_page']) ? $_POST['facebook_page'] : '';

	if ($app_id && $secret) {
		$sql = "UPDATE connection SET app_id = ?, secret = ?, facebook_page = ? WHERE id = 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($app_id, $secret, $facebook_page));
		Database::disconnect();
	}
}
?>

<script type="text/javascript">
	function onClick(href) {
		appid 		= '<?php echo htmlspecialchars($app_id); ?>';
		appsecret 	= '<?php echo htmlspecialchars($secret); ?>';
		if (appid != '' && appsecret != '') {
			return true;
		} else {
			alert('You need save information of APP ID and Secret before press button Login Facebook');
			return false;
		}
	}
</script>

<?php
// Process Facebook Connection
unset($_SESSION['facebook_access_token']);
$loginUrl = '';
if (($app_id != '') && ($secret != '')) {
	$redirect_fbacc = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$fb = new Facebook\Facebook([
		'app_id' 					=> $app_id,
		'app_secret' 				=> $secret,
		'default_graph_version' 	=> 'v2.10',
		'persistent_data_handler'	=> 'session'
	]);

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['user_posts', 'user_photos', 'user_videos', 'publish_to_groups', 'publish_pages', 'manage_pages', 'user_events', 'user_status', 'user_likes']; // Optional permissions
	$loginUrl = $helper->getLoginUrl($redirect_fbacc, $permissions);

	try {
		$fbaccessToken = $helper->getAccessToken($redirect_fbacc);
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	if (isset($fbaccessToken)) {
		$_SESSION['facebook_access_token'] = (string)$fbaccessToken;
		$_SESSION['facebook_access_token'];
	}

	if (@$_SESSION['facebook_access_token'] != '') {
		$access_token = @$_SESSION['facebook_access_token'];

		// Update database
		$sql = "UPDATE connection SET access_token = ? WHERE id = 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($access_token));
		Database::disconnect();
	}

	if ($access_token != '') {
		$res = $fb->get('/me', $access_token);

		// Get User ID
		$user = $res->getGraphObject();
		if ($user->getProperty('id') != '') {
			$user_id = $user->getProperty('id');

			if (@$_SESSION['facebook_access_token'] != '') {
				// Update database
				$sql = "UPDATE connection SET user_id = ? WHERE id = 1";
				$q = $pdo->prepare($sql);
				$q->execute(array($user_id));
				Database::disconnect();
			}
		}

		// Get Facebook Page
		$token_url = 'https://graph.facebook.com/me/accounts?access_token=' . $access_token . '&expires_in=0';
		if (ini_get('allow_url_fopen')) {
			$pagesToken = json_decode(file_get_contents($token_url), true);
		} else {
			$pagesToken = json_decode(file_get_contents_curl($token_url), true);
		}
		if (!empty($user_id)) {
			$id_profile = array('name'=>'Facebook Personal page', 'id'=>$user_id, 'category'=>'Personal page');

			if (!empty($pagesToken['data'])) {
				$pagesToken['data'] = array_merge($pagesToken['data'], array($id_profile));
			} else {
				$pagesToken['data'] = array($id_profile);
			}
		}
	}
}

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
							<section class="panel">
								<header class="panel-heading">Facebook Connection</header>
								<div class="panel-body">
									<form class="form-horizontal" action="index.php" method="post">
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">APP ID <span class="star">*</span></label>
											<div class="col-sm-8">
												<input type="text" name="app_id" class="form-control" value="<?php echo htmlspecialchars($app_id); ?>" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Secret <span class="star">*</span></label>
											<div class="col-sm-8">
												<input type="text" name="secret" class="form-control" value="<?php echo htmlspecialchars($secret); ?>" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Connect Facebook</label>
											<div class="col-sm-8">
												<div class="message">You need save information of APP ID and Secret before press button Login Facebook</div>
												<div><a href="<?php echo htmlspecialchars($loginUrl); ?>" onclick="return onClick(href)"><img src="<?php echo htmlspecialchars($relative_url); ?>assets/images/login_btn.png"></a></div>
												<div>
													<?php if ($user_id) { ?>
														<img class="avatar-img" src="https://graph.facebook.com/<?php echo htmlspecialchars($user_id); ?>/picture" alt="">
													<?php } ?>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">User ID</label>
											<div class="col-sm-8">
												<input type="text" name="user_id" class="form-control" value="<?php echo htmlspecialchars($user_id); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Access Token</label>
											<div class="col-sm-8">
												<input type="text" name="access_token" class="form-control" value="<?php echo htmlspecialchars($access_token); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Facebook Page</label>
											<div class="col-sm-8">
												<select name="facebook_page" class="form-control">
													<?php
													if (isset($pagesToken['data'])) {
														if ($pagesToken['data']) {
															foreach ($pagesToken['data'] as $option_page) { ?>
																<option value="<?php echo htmlspecialchars($option_page['id']); ?>" <?php echo ($option_page['id'] == $facebook_page) ? 'selected="selected"' : ''; ?>><?php echo htmlspecialchars($option_page['name']); ?> - [<?php echo htmlspecialchars($option_page['category']); ?>]</option>
															<?php
															}
														}
													}
													?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-offset-2 col-lg-8">
												<button name="save" type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Save</button>
											</div>
										</div>
									</form>
								</div>
							</section>
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
