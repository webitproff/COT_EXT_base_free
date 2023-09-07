ALTER TABLE `cot_rated` CHANGE `rated_value` `rated_value` tinyint unsigned NOT NULL default '0';
ALTER TABLE `cot_pages` CHANGE `page_rating` `page_rating` decimal(5,2) NOT NULL default '0.00';

ALTER TABLE `cot_ratings` DROP `rating_summ`;
ALTER TABLE `cot_com` DROP `com_rating`;