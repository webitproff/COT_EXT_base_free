CREATE TABLE IF NOT EXISTS `cot_timeline` (
  `item_id` int(10) unsigned NOT NULL auto_increment,  
  `item_userid` int(11) NOT NULL,  
  `item_date` int(11) NOT NULL,
  `item_ext` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `item_text` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_itemid` int(11) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;