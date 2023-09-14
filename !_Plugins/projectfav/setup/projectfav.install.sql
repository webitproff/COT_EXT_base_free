CREATE TABLE IF NOT EXISTS `cot_projectfav` (
	`fav_pid` int(11) NOT NULL default 0,
	`fav_uid` int(11) NOT NULL default 0,
	KEY (`fav_pid`, `fav_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;