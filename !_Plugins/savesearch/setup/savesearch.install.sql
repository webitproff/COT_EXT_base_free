CREATE TABLE IF NOT EXISTS `cot_savesearch` (
	`s_id` int(11) NOT NULL auto_increment,
  `s_uip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `s_uid` int(11) NOT NULL default 0,
  `s_date` int(11) NOT NULL default 0,
  `s_cnt` int(11) NOT NULL default 0,
  `s_save` tinyint(1) NOT NULL default 0,
	`s_code` varchar(255) collate utf8_unicode_ci default NULL,
  `s_var_c` varchar(255) collate utf8_unicode_ci default NULL,
  `s_var_sq` varchar(1020) collate utf8_unicode_ci default NULL,
  `s_params` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
	KEY (`s_id`),
  KEY `s_uid` (`s_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
