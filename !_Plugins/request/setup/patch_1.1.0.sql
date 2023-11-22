
CREATE TABLE IF NOT EXISTS  `cot_requests_pilots` (
  `pilot_rid` int(11) DEFAULT '0',
  `pilot_id` int(11) DEFAULT '0',
  `pilot_comment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  KEY  (`pilot_rid`, `pilot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
