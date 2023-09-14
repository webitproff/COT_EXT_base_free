CREATE TABLE IF NOT EXISTS `cot_checkextrafields` (
	`chk_id` int(11) NOT NULL auto_increment,
	`chk_area` varchar(255) collate utf8_unicode_ci NOT NULL,
	`chk_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
	`chk_set` TEXT collate utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`chk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;