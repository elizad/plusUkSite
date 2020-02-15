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

function make_clickable($text) {
	// The Regular Expression filter
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

	// Check if there is a url in the text
	if (preg_match($reg_exUrl, $text, $url)) {
       // Make the urls hyper links
       return preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
	} else {
       // If no urls in the text just return the text
       return $text;
	}
}

// Format time
function fb_facebook_format_time($time, $date_format) {
	$diff = time() - (int)$time;

	if ($diff == 0) {
		return 'just now';
	}

	$intervals = array(	1                   => array('month', 2629744),
						$diff < 2629744     => array('week', 604800),
						$diff < 604800      => array('day', 86400),
						$diff < 86400       => array('hour', 3600),
						$diff < 3600        => array('minute', 60),
						$diff < 60          => array('second', 1)
					);

	$value = floor($diff / $intervals[1][1]);

	$time_unit = $intervals[1][0];

	switch ($time_unit) {
		case 'week':
			return ($value == 1) ? '1 week ago' : $value . ' weeks ago';
			break;
		case 'day':
			return ($value == 1) ? '1 day ago' : $value . ' days ago';
			break;
		case 'hour':
			return ($value == 1) ? '1 hour ago' : $value . ' hours ago';
			break;
		case 'minute':
			return ($value == 1) ? '1 minute ago' : $value . ' minutes ago';
			break;
		case 'second':
			return ($value == 1) ? '1 second ago' : $value . ' seconds ago';
			break;
		default:
			return date($date_format, $time);
			break;
	}
}

// Format Post Data
function fb_facebook_format_post_data($data) {
	$posts = array();

	if ($data) {
		foreach ($data as $p) {
			// Skip this "post" if it is not of one of the following types
			if (!in_array($p['status_type'], array('added_photos', 'added_video', 'shared_story', 'mobile_status_update'))) {
				continue;
			}

			$post = array();

			// ID
			$id = explode('_', $p['id']);
			$post['id'] = isset($id[1]) ? $id[1] : 0;

			// Type
			$post['type'] = $p['status_type'];

			// Author
			$post['author_image'] = isset($p['from']['picture']['data']['url']) ? $p['from']['picture']['data']['url'] : '';
			$post['author_name'] = isset($p['from']['name']) ? $p['from']['name'] : '';
			$post['author_link'] = isset($p['from']['link']) ? $p['from']['link'] : '';

			// Created time
			$post['created_time'] = $p['created_time'];

			// Content
			$post['content'] = nl2br($p['message']);

			// Image
			$post['image'] = (isset($p['full_picture'])) ? $p['full_picture'] : '';

			// Video
			$post['video'] = isset($p['attachments']['data'][0]['media']['source']) ? $p['attachments']['data'][0]['media']['source'] : '';

			// URL
			$post['url'] = (isset($p['permalink_url'])) ? $p['permalink_url'] : '#';

			// Calculate Comment, Share
			$post['comment_count'] = isset($p['comments']['summary']['total_count']) ? intval($p['comments']['summary']['total_count']) : 0;
			$post['share_count'] = isset($p['shares']['count']) ? intval($p['shares']['count']) : 0;

			// Reaction
			$post['reactions_count'] 	= isset($p['reactions']['summary']['total_count']) ? intval($p['reactions']['summary']['total_count']) : 0;
			$post['reaction_like'] 		= isset($p['like']['summary']['total_count']) ? intval($p['like']['summary']['total_count']) : 0;
			$post['reaction_love'] 		= isset($p['love']['summary']['total_count']) ? intval($p['love']['summary']['total_count']) : 0;
			$post['reaction_haha'] 		= isset($p['haha']['summary']['total_count']) ? intval($p['haha']['summary']['total_count']) : 0;
			$post['reaction_wow'] 		= isset($p['wow']['summary']['total_count']) ? intval($p['wow']['summary']['total_count']) : 0;
			$post['reaction_sad'] 		= isset($p['sad']['summary']['total_count']) ? intval($p['sad']['summary']['total_count']) : 0;
			$post['reaction_angry'] 	= isset($p['angry']['summary']['total_count']) ? intval($p['angry']['summary']['total_count']) : 0;

			// Add to posts array
			$posts[] = $post;
		}
	}

	return $posts;
}

// Format Album Data
function fb_facebook_format_album_data($data) {
	$albums = array();

	if ($data) {
		foreach ($data as $q) {
			$album = array();

			// ID
			$album['id'] = $q['id'];

			// Image
			$album['image'] = isset($q['cover_photo']['source']) ? $q['cover_photo']['source'] : '';

			// Name
			$album['name'] = $q['name'];

			// Count
			$album['count'] = (isset($q['photos']['data']) && (count($q['photos']['data']) > 0)) ? count($q['photos']['data']) : 0;

			// Photos
			$album['photos'] = array();
			if (isset($q['photos']['data']) && (count($q['photos']['data']) > 0)) {
				foreach ($q['photos']['data'] as $p) {
					$photo = array();

					// ID
					$photo['id'] = $p['id'];

					// Type
					$photo['image'] = $p['source'];

					// Author
					$photo['author_image'] = isset($p['from']['picture']['data']['url']) ? $p['from']['picture']['data']['url'] : '';
					$photo['author_name'] = isset($p['from']['name']) ? $p['from']['name'] : '';
					$photo['author_link'] = isset($p['from']['link']) ? $p['from']['link'] : '';

					// Created time
					$photo['created_time'] = $p['created_time'];

					// Content
					$photo['content'] = isset($p['name']) ? nl2br($p['name']) : '';

					// URL
					$photo['url'] = isset($p['link']) ? $p['link'] : '#';

					// Calculate Comment, Share
					$photo['comment_count'] = isset($p['comments']['summary']['total_count']) ? intval($p['comments']['summary']['total_count']) : 0;
					$photo['share_count'] = isset($p['shares']['count']) ? intval($p['shares']['count']) : 0;

					// Reaction
					$photo['reactions_count'] 	= isset($p['reactions']['summary']['total_count']) ? intval($p['reactions']['summary']['total_count']) : 0;
					$photo['reaction_like'] 	= isset($p['like']['summary']['total_count']) ? intval($p['like']['summary']['total_count']) : 0;
					$photo['reaction_love'] 	= isset($p['love']['summary']['total_count']) ? intval($p['love']['summary']['total_count']) : 0;
					$photo['reaction_haha'] 	= isset($p['haha']['summary']['total_count']) ? intval($p['haha']['summary']['total_count']) : 0;
					$photo['reaction_wow'] 		= isset($p['wow']['summary']['total_count']) ? intval($p['wow']['summary']['total_count']) : 0;
					$photo['reaction_sad'] 		= isset($p['sad']['summary']['total_count']) ? intval($p['sad']['summary']['total_count']) : 0;
					$photo['reaction_angry'] 	= isset($p['angry']['summary']['total_count']) ? intval($p['angry']['summary']['total_count']) : 0;

					// Add to posts array
					$album['photos'][] = $photo;
				}
			}

			$albums[] = $album;
		}
	}

	return $albums;
}

// Format Video Data
function fb_facebook_format_video_data($data) {
	$videos = array();

	if ($data) {
		foreach ($data as $p) {
			$video = array();

			// ID
			$video['id'] = $p['id'];

			// Author
			$video['author_image'] = isset($p['from']['picture']['data']['url']) ? $p['from']['picture']['data']['url'] : '';
			$video['author_name'] = isset($p['from']['name']) ? $p['from']['name'] : '';
			$video['author_link'] = isset($p['from']['link']) ? $p['from']['link'] : '';

			// Created time
			$video['created_time'] = $p['created_time'];

			// Title
			$video['title'] = $p['title'];

			// Content
			$video['content'] = $p['description'];

			// Length
			$length = intval(ceil($p['length']));
			$hours = floor($length / 3600);
			$minutes = floor(($length / 60) % 60);
			$seconds = $length % 60;
			$video['length'] = $hours ? $hours . ':' . $minutes . ':' . $seconds : $minutes . ':' . $seconds;

			// Source
			$video['source'] = $p['source'];

			// URL
			$video['url'] = (isset($p['permalink_url'])) ? 'https://www.facebook.com' . $p['permalink_url'] : '#';

			// Calculate Comment, Share
			$video['comment_count'] = isset($p['comments']['summary']['total_count']) ? intval($p['comments']['summary']['total_count']) : 0;
			$video['share_count'] = isset($p['shares']['count']) ? intval($p['shares']['count']) : 0;

			// Reaction
			$video['reactions_count'] 	= isset($p['reactions']['summary']['total_count']) ? intval($p['reactions']['summary']['total_count']) : 0;
			$video['reaction_like'] 	= isset($p['like']['summary']['total_count']) ? intval($p['like']['summary']['total_count']) : 0;
			$video['reaction_love'] 	= isset($p['love']['summary']['total_count']) ? intval($p['love']['summary']['total_count']) : 0;
			$video['reaction_haha'] 	= isset($p['haha']['summary']['total_count']) ? intval($p['haha']['summary']['total_count']) : 0;
			$video['reaction_wow'] 		= isset($p['wow']['summary']['total_count']) ? intval($p['wow']['summary']['total_count']) : 0;
			$video['reaction_sad'] 		= isset($p['sad']['summary']['total_count']) ? intval($p['sad']['summary']['total_count']) : 0;
			$video['reaction_angry'] 	= isset($p['angry']['summary']['total_count']) ? intval($p['angry']['summary']['total_count']) : 0;

			// Add to posts array
			$videos[] = $video;
		}
	}

	return $videos;
}

// Get facebook feed
function fb_facebook_get_feed($year_range, $type) {
	// Set time to display events
	$since_date = strtotime(date('Y-m-d', strtotime('-' . $year_range . ' years')));
	$until_date = strtotime(date('Y-m-d', strtotime('+' . $year_range . ' years')));

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT * FROM connection where id = 1';
	$q = $pdo->prepare($sql);
	$q->execute();
	$connection = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();

	$fb_page_id 	= $connection ? $connection['facebook_page'] : '';
	$access_token 	= $connection ? $connection['access_token'] : '';

	$react = ',reactions.type(LIKE).limit(0).summary(1).as(like)';
	$react .= ',reactions.type(LOVE).limit(0).summary(1).as(love)';
	$react .= ',reactions.type(HAHA).limit(0).summary(1).as(haha)';
	$react .= ',reactions.type(WOW).limit(0).summary(1).as(wow)';
	$react .= ',reactions.type(SAD).limit(0).summary(1).as(sad)';
	$react .= ',reactions.type(ANGRY).limit(0).summary(1).as(angry)';
	if ($type == 'post') {
		$fields = "id,full_picture,status_type,from{picture,name,link},created_time,message,permalink_url,attachments,reactions.limit(1).summary(true),comments.limit(1).summary(true),shares.limit(1).summary(true)" . $react;
		$json_link = "https://graph.facebook.com/v4.0/{$fb_page_id}/posts/?fields={$fields}&access_token={$access_token}&since={$since_date}&until={$until_date}&limit=100";
	} elseif ($type == 'album') {
		$fields = "albums.fields(id,name,cover_photo.fields(id,name,source),photos.fields(source,from{picture,name,link},created_time,name,link,reactions.limit(1).summary(true),comments.limit(1).summary(true),shares.limit(1).summary(true)" . $react . "))";
		$json_link = "https://graph.facebook.com/v4.0/{$fb_page_id}/?fields={$fields}&access_token={$access_token}&since={$since_date}&until={$until_date}&limit=100";
	} elseif ($type == 'video') {
		$fields = "id,source,from{picture,name,link},created_time,length,title,description,permalink_url,reactions.limit(1).summary(true),comments.limit(1).summary(true)" . $react;
		$json_link = "https://graph.facebook.com/v4.0/{$fb_page_id}/videos/?fields={$fields}&access_token={$access_token}&since={$since_date}&until={$until_date}&limit=100";
	}

	if (ini_get('allow_url_fopen')) {
		$json = file_get_contents($json_link);
	} else {
		$json = curl_get_contents($json_link);
	}

	// Decode json from Facebook Graph API
	$fb_events = json_decode($json, true);

	if ($type == 'post') {
		if (isset($fb_events['data']) && (count($fb_events['data']) > 0)) {
			return fb_facebook_format_post_data($fb_events['data']);
		}
	} elseif ($type == 'album') {
		if (isset($fb_events['albums']['data']) && (count($fb_events['albums']['data']) > 0)) {
			return fb_facebook_format_album_data($fb_events['albums']['data']);
		}
	} elseif ($type == 'video') {
		if (isset($fb_events['data']) && (count($fb_events['data']) > 0)) {
			return fb_facebook_format_video_data($fb_events['data']);
		}
	}
}

// Facebook feed content
function fb_facebook_feed_content($year_range, $initial_view, $switch_button, $readmore_button, $num_items, $date_format) {
	$posts = fb_facebook_get_feed($year_range, 'post');
	$albums = fb_facebook_get_feed($year_range, 'album');
	$videos = fb_facebook_get_feed($year_range, 'video');
	?>

	<style>
	.fb-facebook-all-in-one .fb-facebook-tab-content .content-tab {
		display: none;
	}
	</style>

	<div class="fb-facebook-feed fb-facebook-tab">
		<?php if ($switch_button == 'show') { ?>
			<div class="fb-facebook-tab-bar">
				<a href="#tab-post" class="btn <?php echo ($initial_view == 'post') ? 'active' : ''; ?>"><i class="fa fa-file-text-o" aria-hidden="true"></i>Posts</a>
				<a href="#tab-photo" class="btn <?php echo ($initial_view == 'photo') ? 'active' : ''; ?>"><i class="fa fa-file-image-o" aria-hidden="true"></i>Photos</a>
				<a href="#tab-album" class="btn <?php echo ($initial_view == 'album') ? 'active' : ''; ?>"><i class="fa fa-picture-o" aria-hidden="true"></i>Albums</a>
				<a href="#tab-video" class="btn <?php echo ($initial_view == 'video') ? 'active' : ''; ?>"><i class="fa fa-file-video-o" aria-hidden="true"></i>Videos</a>
			</div>
		<?php } ?>

		<div class="fb-facebook-tab-content">
			<!-- Post -->
			<div id="tab-post" class="fb-facebook-post masonry content-tab <?php echo ($initial_view == 'post') ? 'active' : ''; ?>">
				<div class="loading">
					<img src="assets/images/loading.gif">
				</div>

				<div class="facebook-posts grid">
					<div class="gutter-sizer"></div>

					<?php if ($posts) { ?>
						<?php foreach ($posts as $i=>$post) { ?>
							<div class="facebook-post-item grid-item <?php echo ($i < $num_items) ? 'active' : ''; ?>">
								<div class="author pull-left">
									<div class="image pull-left">
										<a href="<?php echo htmlspecialchars($post['author_link']); ?>">
											<img src="<?php echo htmlspecialchars($post['author_image']); ?>" alt="<?php echo htmlspecialchars($post['author_name']); ?>">
										</a>
									</div>
									<div class="pull-left">
										<div class="name"><a href="<?php echo htmlspecialchars($post['author_link']); ?>"><?php echo htmlspecialchars($post['author_name']); ?></a></div>
										<div class="time"><?php echo fb_facebook_format_time(strtotime($post['created_time']), $date_format); ?></div>
									</div>
									<div class="pull-right">
										<span class="share"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($post['url']); ?>" target="_blank" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i></a></span>
										<span class="go-facebook"><a href="<?php echo htmlspecialchars($post['url']); ?>" target="_blank" title="View on Facebook"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
									</div>
								</div>
								<div class="content">
									<?php echo make_clickable($post['content']); ?>
								</div>
								<?php if ($post['image']) { ?>
									<div class="image">
										<a class="open-popup" href="#feed-popup-<?php echo htmlspecialchars($post['id']); ?>">
											<img src="<?php echo htmlspecialchars($post['image']); ?>">
											<?php if ($post['type'] == 'added_video') { ?>
												<div class="video-play"></div>
											<?php } ?>
										</a>
										<div id="feed-popup-<?php echo htmlspecialchars($post['id']); ?>" class="fb-facebook-feed-popup zoom-anim-dialog mfp-hide">
											<div class="popup-container pull-left">
												<div class="popup-left pull-left">
													<?php if ($post['type'] == 'added_video') { ?>
														<video src="<?php echo htmlspecialchars($post['video']); ?>" controls></video>
													<?php } else { ?>
														<img src="<?php echo htmlspecialchars($post['image']); ?>">
													<?php } ?>
												</div>
												<div class="popup-right pull-left">
													<div class="fb-facebook-feed">
														<div class="facebook-post-item">
															<div class="author pull-left">
																<div class="image pull-left">
																	<a href="<?php echo htmlspecialchars($post['author_link']); ?>">
																		<img src="<?php echo htmlspecialchars($post['author_image']); ?>" alt="<?php echo htmlspecialchars($post['author_name']); ?>">
																	</a>
																</div>
																<div class="pull-left">
																	<div class="name"><a href="<?php echo htmlspecialchars($post['author_link']); ?>"><?php echo htmlspecialchars($post['author_name']); ?></a></div>
																	<div class="time"><?php echo fb_facebook_format_time(strtotime($post['created_time']), $date_format); ?></div>
																</div>
																<div class="pull-right">
																	<span class="share"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($post['url']); ?>" target="_blank" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i></a></span>
																	<span class="go-facebook"><a href="<?php echo htmlspecialchars($post['url']); ?>" target="_blank" title="View on Facebook"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
																</div>
															</div>
															<div class="content">
																<?php echo make_clickable($post['content']); ?>
															</div>
															<div class="bottom-bar">
																<?php if ($post['reactions_count']) { ?>
																	<span class="item">
																		<?php if ($post['reaction_like']) echo '<img class="like" src="assets/images/like.png" alt="like">'; ?>
																		<?php if ($post['reaction_love']) echo '<img class="love" src="assets/images/love.png" alt="love">'; ?>
																		<?php if ($post['reaction_haha']) echo '<img class="haha" src="assets/images/haha.png" alt="haha">'; ?>
																		<?php if ($post['reaction_wow']) echo '<img class="wow" src="assets/images/wow.png" alt="wow">'; ?>
																		<?php if ($post['reaction_sad']) echo '<img class="sad" src="assets/images/sad.png" alt="sad">'; ?>
																		<?php if ($post['reaction_angry']) echo '<img class="angry" src="assets/images/angry.png" alt="angry">'; ?>
																		<?php echo htmlspecialchars($post['reactions_count']); ?>
																	</span>
																<?php } ?>
																<span class="pull-right">
																	<?php if ($post['comment_count']) { ?>
																		<span class="item"><?php echo htmlspecialchars($post['comment_count']); ?> Comments</span>
																	<?php } ?>
																	<?php if ($post['share_count']) { ?>
																		<span class="item"><?php echo htmlspecialchars($post['share_count']); ?> Shares</span>
																	<?php } ?>
																</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="bottom-bar">
									<?php if ($post['reactions_count']) { ?>
										<span class="item">
											<?php if ($post['reaction_like']) echo '<img class="like" src="assets/images/like.png" alt="like">'; ?>
											<?php if ($post['reaction_love']) echo '<img class="love" src="assets/images/love.png" alt="love">'; ?>
											<?php if ($post['reaction_haha']) echo '<img class="haha" src="assets/images/haha.png" alt="haha">'; ?>
											<?php if ($post['reaction_wow']) echo '<img class="wow" src="assets/images/wow.png" alt="wow">'; ?>
											<?php if ($post['reaction_sad']) echo '<img class="sad" src="assets/images/sad.png" alt="sad">'; ?>
											<?php if ($post['reaction_angry']) echo '<img class="angry" src="assets/images/angry.png" alt="angry">'; ?>
											<?php echo htmlspecialchars($post['reactions_count']); ?>
										</span>
									<?php } ?>
									<span class="pull-right">
										<?php if ($post['comment_count']) { ?>
											<span class="item"><?php echo htmlspecialchars($post['comment_count']); ?> Comments</span>
										<?php } ?>
										<?php if ($post['share_count']) { ?>
											<span class="item"><?php echo htmlspecialchars($post['share_count']); ?> Shares</span>
										<?php } ?>
									</span>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>

				<?php if ($readmore_button == 'show') { ?>
					<div class="read-more">
						<a href="#" class="btn btn-primary">Load more</a>
					</div>
				<?php } ?>
			</div>

			<!-- Photo -->
			<div id="tab-photo" class="fb-facebook-photo masonry content-tab <?php echo ($initial_view == 'photo') ? 'active' : ''; ?>">
				<div class="loading">
					<img src="assets/images/loading.gif">
				</div>
				<div class="facebook-photos grid">
					<div class="gutter-sizer"></div>

					<?php $k = 0; ?>
					<?php if ($albums) { ?>
						<?php foreach ($albums as $album) { ?>
							<?php if ($album['photos']) { ?>
								<?php foreach ($album['photos'] as $photo) { ?>
									<div class="facebook-photo-item grid-item <?php echo ($k < $num_items) ? 'active' : ''; ?>">
										<?php if ($photo['image']) { ?>
											<div class="image">
												<a class="open-popup" href="#feed-popup-<?php echo htmlspecialchars($photo['id']); ?>">
													<img src="<?php echo htmlspecialchars($photo['image']); ?>">
												</a>
												<div id="feed-popup-<?php echo htmlspecialchars($photo['id']); ?>" class="fb-facebook-feed-popup zoom-anim-dialog mfp-hide">
													<div class="popup-container pull-left">
														<div class="popup-left pull-left">
															<img src="<?php echo htmlspecialchars($photo['image']); ?>">
														</div>
														<div class="popup-right pull-left">
															<div class="fb-facebook-feed">
																<div class="facebook-post-item">
																	<div class="author pull-left">
																		<div class="image pull-left">
																			<a href="<?php echo htmlspecialchars($photo['author_link']); ?>">
																				<img src="<?php echo htmlspecialchars($photo['author_image']); ?>" alt="<?php echo htmlspecialchars($photo['author_name']); ?>">
																			</a>
																		</div>
																		<div class="pull-left">
																			<div class="name"><a href="<?php echo htmlspecialchars($photo['author_link']); ?>"><?php echo htmlspecialchars($photo['author_name']); ?></a></div>
																			<div class="time"><?php echo fb_facebook_format_time(strtotime($photo['created_time']), $date_format); ?></div>
																		</div>
																		<div class="pull-right">
																			<span class="share"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($photo['url']); ?>" target="_blank" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i></a></span>
																			<span class="go-facebook"><a href="<?php echo htmlspecialchars($photo['url']); ?>" target="_blank" title="View on Facebook"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
																		</div>
																	</div>
																	<div class="content">
																		<?php echo make_clickable($photo['content']); ?>
																	</div>
																	<div class="bottom-bar">
																		<?php if ($photo['reactions_count']) { ?>
																			<span class="item">
																				<?php if ($photo['reaction_like']) echo '<img class="like" src="assets/images/like.png" alt="like">'; ?>
																				<?php if ($photo['reaction_love']) echo '<img class="love" src="assets/images/love.png" alt="love">'; ?>
																				<?php if ($photo['reaction_haha']) echo '<img class="haha" src="assets/images/haha.png" alt="haha">'; ?>
																				<?php if ($photo['reaction_wow']) echo '<img class="wow" src="assets/images/wow.png" alt="wow">'; ?>
																				<?php if ($photo['reaction_sad']) echo '<img class="sad" src="assets/images/sad.png" alt="sad">'; ?>
																				<?php if ($photo['reaction_angry']) echo '<img class="angry" src="assets/images/angry.png" alt="angry">'; ?>
																				<?php echo htmlspecialchars($photo['reactions_count']); ?>
																			</span>
																		<?php } ?>
																		<span class="pull-right">
																			<?php if ($photo['comment_count']) { ?>
																				<span class="item"><?php echo htmlspecialchars($photo['comment_count']); ?> Comments</span>
																			<?php } ?>
																			<?php if ($photo['share_count']) { ?>
																				<span class="item"><?php echo htmlspecialchars($photo['share_count']); ?> Shares</span>
																			<?php } ?>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
									<?php $k++; ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>

				<?php if ($readmore_button == 'show') { ?>
					<div class="read-more">
						<a href="#" class="btn btn-primary">Load more</a>
					</div>
				<?php } ?>
			</div>

			<!-- Album -->
			<div id="tab-album" class="fb-facebook-album content-tab <?php echo ($initial_view == 'album') ? 'active' : ''; ?>">
				<div class="facebook-albums">
					<?php if ($albums) { ?>
						<?php foreach ($albums as $album) { ?>
							<div class="facebook-album-item">
								<?php if ($album['image']) { ?>
									<div class="album-image-wrap">
										<div class="album-image">
											<a href="#album-<?php echo htmlspecialchars($album['id']); ?>" class="open-album">
												<img src="<?php echo htmlspecialchars($album['image']); ?>">
											</a>
										</div>
									</div>
									<div class="album-name open-album">
										<a href="#album-<?php echo htmlspecialchars($album['id']); ?>" class="open-album">
											<?php echo htmlspecialchars($album['name']); ?>
										</a>
									</div>
									<div class="album-count">
										<?php echo htmlspecialchars($album['count']); ?> Photos</a>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>

				<?php if ($albums) { ?>
					<?php foreach ($albums as $album) { ?>
						<div id="album-<?php echo htmlspecialchars($album['id']); ?>" class="album-photos">
							<div class="fb-facebook-photo masonry">
								<div class="loading">
									<img src="assets/images/loading.gif">
								</div>

								<div class="facebook-photos grid">
									<div class="gutter-sizer"></div>

									<?php $k = 0; ?>
									<?php if ($album['photos']) { ?>
										<?php foreach ($album['photos'] as $photo) { ?>
											<div class="facebook-photo-item grid-item <?php echo ($k < $num_items) ? 'active' : ''; ?>">
												<?php if ($photo['image']) { ?>
													<div class="image">
														<a class="open-popup" href="#feed-popup-<?php echo htmlspecialchars($photo['id']); ?>">
															<img src="<?php echo htmlspecialchars($photo['image']); ?>">
														</a>
														<div id="feed-popup-<?php echo htmlspecialchars($photo['id']); ?>" class="fb-facebook-feed-popup zoom-anim-dialog mfp-hide">
															<div class="popup-container pull-left">
																<div class="popup-left pull-left">
																	<img src="<?php echo htmlspecialchars($photo['image']); ?>">
																</div>
																<div class="popup-right pull-left">
																	<div class="fb-facebook-feed">
																		<div class="facebook-post-item">
																			<div class="author pull-left">
																				<div class="image pull-left">
																					<a href="<?php echo htmlspecialchars($photo['author_link']); ?>">
																						<img src="<?php echo htmlspecialchars($photo['author_image']); ?>" alt="<?php echo htmlspecialchars($photo['author_name']); ?>">
																					</a>
																				</div>
																				<div class="pull-left">
																					<div class="name"><a href="<?php echo htmlspecialchars($photo['author_link']); ?>"><?php echo htmlspecialchars($photo['author_name']); ?></a></div>
																					<div class="time"><?php echo fb_facebook_format_time(strtotime($photo['created_time']), $date_format); ?></div>
																				</div>
																				<div class="pull-right">
																					<span class="share"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($photo['url']); ?>" target="_blank" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i></a></span>
																					<span class="go-facebook"><a href="<?php echo htmlspecialchars($photo['url']); ?>" target="_blank" title="View on Facebook"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
																				</div>
																			</div>
																			<div class="content">
																				<?php echo make_clickable($photo['content']); ?>
																			</div>
																			<div class="bottom-bar">
																				<?php if ($photo['reactions_count']) { ?>
																					<span class="item">
																						<?php if ($photo['reaction_like']) echo '<img class="like" src="assets/images/like.png" alt="like">'; ?>
																						<?php if ($photo['reaction_love']) echo '<img class="love" src="assets/images/love.png" alt="love">'; ?>
																						<?php if ($photo['reaction_haha']) echo '<img class="haha" src="assets/images/haha.png" alt="haha">'; ?>
																						<?php if ($photo['reaction_wow']) echo '<img class="wow" src="assets/images/wow.png" alt="wow">'; ?>
																						<?php if ($photo['reaction_sad']) echo '<img class="sad" src="assets/images/sad.png" alt="sad">'; ?>
																						<?php if ($photo['reaction_angry']) echo '<img class="angry" src="assets/images/angry.png" alt="angry">'; ?>
																						<?php echo htmlspecialchars($photo['reactions_count']); ?>
																					</span>
																				<?php } ?>
																				<span class="pull-right">
																					<?php if ($photo['comment_count']) { ?>
																						<span class="item"><?php echo htmlspecialchars($photo['comment_count']); ?> Comments</span>
																					<?php } ?>
																					<?php if ($photo['share_count']) { ?>
																						<span class="item"><?php echo htmlspecialchars($photo['share_count']); ?> Shares</span>
																					<?php } ?>
																				</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
											</div>
											<?php $k++; ?>
										<?php } ?>
									<?php } ?>
								</div>

								<?php if ($readmore_button == 'show') { ?>
									<div class="read-more">
										<a href="#" class="btn btn-primary">Load more</a>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>

			<!-- Video -->
			<div id="tab-video" class="fb-facebook-video masonry content-tab <?php echo ($initial_view == 'video') ? 'active' : ''; ?>">
				<div class="loading">
					<img src="assets/images/loading.gif">
				</div>

				<div class="facebook-videos grid">
					<div class="gutter-sizer"></div>

					<?php if ($videos) { ?>
						<?php foreach ($videos as $i=>$video) { ?>
							<div class="facebook-video-item grid-item <?php echo ($i < $num_items) ? 'active' : ''; ?>">
								<?php if ($video['source']) { ?>
									<div class="video">
										<a class="open-popup" href="#feed-popup-<?php echo htmlspecialchars($video['id']); ?>">
											<video src="<?php echo htmlspecialchars($video['source']); ?>"></video>
											<div class="video-play"></div>
											<div class="video-length"><?php echo htmlspecialchars($video['length']); ?></div>
										</a>
									</div>
									<div class="title"><a class="open-popup" href="#feed-popup-<?php echo htmlspecialchars($video['id']); ?>"><?php echo htmlspecialchars($video['title']); ?></a></div>
									<div class="time"><?php echo fb_facebook_format_time(strtotime($video['created_time']), $date_format); ?></div>
									<div id="feed-popup-<?php echo htmlspecialchars($video['id']); ?>" class="fb-facebook-feed-popup zoom-anim-dialog mfp-hide">
										<div class="popup-container pull-left">
											<div class="popup-left pull-left">
												<video src="<?php echo htmlspecialchars($video['source']); ?>" controls></video>
											</div>
											<div class="popup-right pull-left">
												<div class="fb-facebook-feed">
													<div class="facebook-post-item">
														<div class="author pull-left">
															<div class="image pull-left">
																<a href="<?php echo htmlspecialchars($video['author_link']); ?>">
																	<img src="<?php echo htmlspecialchars($video['author_image']); ?>" alt="<?php echo htmlspecialchars($video['author_name']); ?>">
																</a>
															</div>
															<div class="pull-left">
																<div class="name"><a href="<?php echo htmlspecialchars($video['author_link']); ?>"><?php echo htmlspecialchars($video['author_name']); ?></a></div>
																<div class="time"><?php echo fb_facebook_format_time(strtotime($video['created_time']), $date_format); ?></div>
															</div>
															<div class="pull-right">
																<span class="share"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($video['url']); ?>" target="_blank" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i></a></span>
																<span class="go-facebook"><a href="<?php echo htmlspecialchars($video['url']); ?>" target="_blank" title="View on Facebook"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>
															</div>
														</div>
														<div class="content">
															<?php echo make_clickable($video['content']); ?>
														</div>
														<div class="bottom-bar">
															<?php if ($video['reactions_count']) { ?>
																<span class="item">
																	<?php if ($video['reaction_like']) echo '<img class="like" src="assets/images/like.png" alt="like">'; ?>
																	<?php if ($video['reaction_love']) echo '<img class="love" src="assets/images/love.png" alt="love">'; ?>
																	<?php if ($video['reaction_haha']) echo '<img class="haha" src="assets/images/haha.png" alt="haha">'; ?>
																	<?php if ($video['reaction_wow']) echo '<img class="wow" src="assets/images/wow.png" alt="wow">'; ?>
																	<?php if ($video['reaction_sad']) echo '<img class="sad" src="assets/images/sad.png" alt="sad">'; ?>
																	<?php if ($video['reaction_angry']) echo '<img class="angry" src="assets/images/angry.png" alt="angry">'; ?>
																	<?php echo htmlspecialchars($video['reactions_count']); ?>
																</span>
															<?php } ?>
															<span class="pull-right">
																<?php if ($video['comment_count']) { ?>
																	<span class="item"><?php echo htmlspecialchars($video['comment_count']); ?> Comments</span>
																<?php } ?>
																<?php if ($video['share_count']) { ?>
																	<span class="item"><?php echo htmlspecialchars($video['share_count']); ?> Shares</span>
																<?php } ?>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>

				<?php if ($readmore_button == 'show') { ?>
					<div class="read-more">
						<a href="#" class="btn btn-primary">Load more</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}

function fb_facebook_feed() {
	// Get settings
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT * FROM settings where id = 1';
	$q = $pdo->prepare($sql);
	$q->execute();
	$settings = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();

	$year_range 		= $settings ? $settings['feed_year_range'] : 3;
	$initial_view 		= $settings ? $settings['feed_initial_view'] : 'post';
	$switch_button 		= $settings ? $settings['feed_switch_button'] : 'show';
	$readmore_button 	= $settings ? $settings['feed_readmore_button'] : 'show';
	$num_items 			= $settings ? $settings['feed_num_items'] : 9;
	$date_format 		= $settings ? $settings['feed_date_format'] : 'F d, Y';
	?>

	<div class="fb-facebook-all-in-one">
		<?php fb_facebook_feed_content($year_range, $initial_view, $switch_button, $readmore_button, $num_items, $date_format); ?>
	</div>
<?php
}
