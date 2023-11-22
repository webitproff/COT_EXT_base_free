CREATE TABLE IF NOT EXISTS `cot_showcontact` (
  `sc_id` int(10) unsigned NOT NULL auto_increment,
  `sc_userid` int(11) NOT NULL,
  `sc_uid` int(11) NOT NULL,
  `sc_date` int(11) NOT NULL,
  `sc_area` VARCHAR(255) NOT NULL DEFAULT '',
  `sc_url` VARCHAR(255) NOT NULL DEFAULT '',
  `sc_status` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`sc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;