DROP TABLE IF EXISTS `cot_whowhere`;
CREATE TABLE `cot_whowhere` (
  `ww_id` int NOT NULL auto_increment,
  `ww_ip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `ww_userid` int(11) NOT NULL default '0',
  `ww_date` int(11) NOT NULL default '0',
  `ww_code` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_e` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_m` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_n` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_c` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_id` int(11) NOT NULL default '0',
  `ww_var_al` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ww_var_url` varchar(1020) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`ww_id`),
  KEY `ww_userid` (`ww_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
