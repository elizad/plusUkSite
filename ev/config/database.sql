--
-- Table structure for table `connection`
--

CREATE TABLE IF NOT EXISTS `connection` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`app_id` varchar(100),
	`secret` varchar(100),
	`user_id` varchar(100),
	`access_token` text,
	`facebook_page` varchar(100),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `connection`
--

INSERT INTO `connection` (`id`, `app_id`, `secret`, `user_id`, `access_token`, `facebook_page`) VALUES
(1, '', '', '', '', '');

-- ------------------------------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`events_layout` varchar(10),
	`events_year_range` int(11),
	`events_initial_view` varchar(10),
	`events_start_date` varchar(10),
	`events_switch_button` varchar(10),
	`events_list_filter` varchar(10),
	`events_show_title` varchar(10),
	`events_num_items` int(11),
	`events_time_format` varchar(10),
	`events_date_format` varchar(20),
	`feed_year_range` int(11),
	`feed_initial_view` varchar(10),
	`feed_switch_button` varchar(10),
	`feed_readmore_button` varchar(10),
	`feed_num_items` int(11),
	`feed_date_format` varchar(10),
	`messenger_language` varchar(10),
	`messenger_mobile` tinyint(4),
	`messenger_position` varchar(10),
	`messenger_hello` text,
	`likebox_language` varchar(10),
	`likebox_mobile` tinyint(4),
	`likebox_width` int(11),
	`likebox_height` int(11),
	`likebox_tab_timeline` tinyint(4) DEFAULT '0',
	`likebox_tab_events` tinyint(4) DEFAULT '0',
	`likebox_tab_messages` tinyint(4) DEFAULT '0',
	`likebox_position` varchar(10),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `events_layout`, `events_year_range`, `events_initial_view`, `events_start_date`, `events_switch_button`, `events_list_filter`, `events_show_title`, `events_num_items`, `events_time_format`, `events_date_format`, `feed_year_range`, `feed_initial_view`, `feed_switch_button`, `feed_readmore_button`, `feed_num_items`, `feed_date_format`, `messenger_language`, `messenger_mobile`, `messenger_position`, `messenger_hello`, `likebox_language`, `likebox_mobile`, `likebox_width`, `likebox_height`, `likebox_tab_timeline`, `likebox_tab_events`, `likebox_tab_messages`, `likebox_position`) VALUES
(1, 'full', 3, 'calendar', 'sunday', 'show', 'all', 'show', 1000, '24', 'l, d F Y', 3, 'post', 'show', 'show', 9, 'F d, Y', 'en_US', 0, 'right', '', 'en_US', 0, 300, 400, 0, 0, 0, 'right');

-- ------------------------------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`password` char(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`salt` char(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`role` int(11) NOT NULL,
	`state` tinyint(3) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`username`),
	UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `salt`, `email`, `role`, `state`) VALUES
(1, 'Admin', 'admin', 'fd7e8a4c36e88f882e1a3db5ef3b14f1e1a0b0a7a12b660f70f2bda389c94355', '32adb74318e6e57f', 'admin@gmail.com', 1, 1);
