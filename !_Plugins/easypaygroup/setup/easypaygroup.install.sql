CREATE TABLE IF NOT EXISTS  `cot_easypaygroup` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `item_code` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `item_date` int(11) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
