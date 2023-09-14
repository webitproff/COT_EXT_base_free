/**
 * ukarma orders DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_ukarma` (
  `ukarma_id` int(10) unsigned NOT NULL auto_increment,
  `ukarma_area` varchar(255) collate utf8_unicode_ci default NULL,
  `ukarma_code` varchar(255) collate utf8_unicode_ci default NULL,
  `ukarma_userid` int(11) NOT NULL,
  `ukarma_ownerid` int(11) NOT NULL,
  `ukarma_value` char(5) NOT NULL,
  `ukarma_date` int(11) NOT NULL,
  PRIMARY KEY  (`ukarma_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;