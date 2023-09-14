CREATE TABLE IF NOT EXISTS `cot_searchforms` (
	`form_id` int(11) NOT NULL auto_increment,
	`form_code` varchar(255) collate utf8_unicode_ci NOT NULL,
	`form_set` TEXT collate utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;