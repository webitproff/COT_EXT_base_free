CREATE TABLE IF NOT EXISTS `cot_ads` (
  `item_id` INTEGER NOT NULL auto_increment,
  `item_userid` int(11) NOT NULL,
  `item_title` VARCHAR(255) NOT NULL DEFAULT '',
  `item_cat` VARCHAR(255) NOT NULL DEFAULT '',
  `item_file` VARCHAR(255) DEFAULT '',
  `item_filetype` VARCHAR(255) DEFAULT '',
  `item_alt` VARCHAR(255) DEFAULT '',
  `item_clickurl` VARCHAR(200) DEFAULT '',
  `item_description` TEXT DEFAULT '',
  `item_paused` int(11) NOT NULL DEFAULT 0,
  `item_begin` int(11) NOT NULL DEFAULT 0, 
  `item_expire` int(11) NOT NULL DEFAULT 0,
  `item_period` int(11) NOT NULL DEFAULT 0,
  `item_track_clicks` int(11) DEFAULT 0,
  `item_track_shows` int(11) DEFAULT 0,
  `item_lastshow` int(11) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'ads';