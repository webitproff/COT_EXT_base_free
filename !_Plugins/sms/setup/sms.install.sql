CREATE TABLE IF NOT EXISTS `cot_sms_logs` (
  `log_id`     int(11) unsigned NOT NULL auto_increment,
  `log_api`  varchar(50) collate utf8_unicode_ci DEFAULT '',
  `log_phone`  varchar(50) collate utf8_unicode_ci DEFAULT '',
  `log_text`  varchar(255) collate utf8_unicode_ci DEFAULT '',
  `log_status`  varchar(50) collate utf8_unicode_ci DEFAULT '',
  `log_userid` int(11) DEFAULT '0',
  `log_date`   int(11) DEFAULT '0',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;