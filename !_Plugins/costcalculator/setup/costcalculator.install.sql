/* costcalculator schema */

-- Main costcalculator table
CREATE TABLE IF NOT EXISTS `cot_cc_calcs` (
	`cc_id` int(11) NOT NULL auto_increment,
	`cc_name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`cc_desc` text(500) collate utf8_unicode_ci NOT NULL default '',
	`cc_groups` text(500) collate utf8_unicode_ci NOT NULL,
	`cc_order` int(4) default NULL,	
	PRIMARY KEY (`cc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Rows costcalculator table
CREATE TABLE IF NOT EXISTS `cot_cc_calcs_rows` (
	`ccr_id` int(11) NOT NULL auto_increment,
	`cc_id` int(11) NOT NULL,
	`ccr_name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ccr_desc` text(500) collate utf8_unicode_ci NOT NULL default '',
	`ccr_units` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ccr_order` int(4) default NULL,	
	PRIMARY KEY (`ccr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- User cost costcalculator table
CREATE TABLE IF NOT EXISTS `cot_cc_calcs_users_cost` (
	`ccu_id` int(11) NOT NULL auto_increment,
	`ccr_id` int(11) NOT NULL,
	`ccu_user_id` int(11) NOT NULL,
	`ccu_cost` float(11) NOT NULL,
	`ccu_updated` int(11) NOT NULL,	
	PRIMARY KEY (`ccu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;