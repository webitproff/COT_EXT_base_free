CREATE TABLE IF NOT EXISTS `cot_userwall` (
	`item_id` int(11) NOT NULL auto_increment,
	`item_userid` int(11) default NULL,
	`item_date` int(11) NOT NULL default '0',
	`item_text` text collate utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`item_id`),
	KEY (`item_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_userwall_likes` (
	`like_pid` int(11) NOT NULL default 0,
	`like_uid` int(11) NOT NULL default 0,
	KEY (`like_pid`, `like_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;