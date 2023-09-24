/* favoriteusers schema */
CREATE TABLE IF NOT EXISTS `cot_favorite_users` (
  `favu_id` int(11) unsigned NOT NULL auto_increment,
  `favu_user_id` int(11) NOT NULL,
  `favu_added_user_id` int(11) NOT NULL,
  PRIMARY KEY  (`favu_id`),
  UNIQUE KEY  `favu_row` (`favu_user_id`, `favu_added_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
