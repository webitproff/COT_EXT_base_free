/**
 * Completely removes ads data and tables
 */

DROP TABLE IF EXISTS `cot_ads`;

DELETE FROM `cot_structure` WHERE `structure_area` = 'ads';