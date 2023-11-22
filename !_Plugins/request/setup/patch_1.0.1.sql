
CREATE TABLE IF NOT EXISTS  `cot_requests` (
  `request_id` int(10) unsigned NOT NULL auto_increment,
  `request_date` int(11) DEFAULT '0',
  `request_userid` int(11) DEFAULT '0',
  `request_title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_deadline` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_phone` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_pilots` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `request_performer` int(11) DEFAULT '0',
  `request_cost` float(16,2) default NULL,
  `request_status` varchar(50) collate utf8_unicode_ci NOT NULL default 'new',
  PRIMARY KEY  (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
