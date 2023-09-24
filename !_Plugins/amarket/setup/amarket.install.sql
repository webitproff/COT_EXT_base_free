/* amarket schema */
CREATE TABLE IF NOT EXISTS `cot_amarket_products` (
  `amp_id` int(11) unsigned NOT NULL auto_increment,
  `amp_prd_id` int(11) NOT NULL,
  `amp_prd_count` int(11) NOT NULL,
  `amo_id` int(11) NOT NULL,
  PRIMARY KEY  (`amp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_amarket_orders` (
  `amo_id` int(11) unsigned NOT NULL auto_increment,
  `amo_seller` int(11) NOT NULL,
  `amo_customer` int(11) NOT NULL,
  `amo_added` int(11) NOT NULL,
  `amo_change` int(11) NOT NULL,
  `amo_status` int(1) NOT NULL,
  `amo_cancel_reason` text,
  PRIMARY KEY  (`amo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
