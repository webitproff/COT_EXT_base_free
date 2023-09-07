ALTER TABLE `cot_rated` CHANGE `rated_value` `rated_value` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `cot_pages` CHANGE `page_rating` `page_rating` INT( 11 ) NOT NULL DEFAULT '0';

ALTER TABLE `cot_ratings` ADD `rating_summ` INT( 11 ) NOT NULL DEFAULT '0' AFTER `rating_average`;
ALTER TABLE `cot_com` ADD `com_rating` INT( 11 ) NOT NULL DEFAULT '0';