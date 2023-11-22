
CREATE TABLE IF NOT EXISTS `cot_seo` (
  `seo_id` int(11) unsigned NOT NULL auto_increment,
  `seo_area` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `seo_category` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `seo_city` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `seo_title` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `seo_desc` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `seo_text` MEDIUMTEXT collate utf8_unicode_ci,
  PRIMARY KEY  (`seo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cot_seo` (`seo_id`, `seo_area`, `seo_category`, `seo_city`, `seo_title`, `seo_text`) VALUES
(1, 'users', '', '', 'Поиск пилотов дронов', ''),
(2, 'users', '*', '*', 'Съемка {CATEGORY} с квадрокоптера {CITY_GDE}', ''),
(3, 'users', 'estate', '*', 'Съемка недвижимости с квадрокоптера {CITY_GDE}', ''),
(4, 'users', '3d', '*', '3D-сканирование с квадрокоптера {CITY_GDE}', ''),
(5, 'users', 'clips', '*', 'Съемка рекламы и клипов с квадрокоптера {CITY_GDE}', ''),
(6, 'users', 'movie', '*', 'Съемки для ТВ и кино с квадрокотера {CITY_GDE}', ''),
(7, 'users', 'arenda', '*', 'Аренда дрона {CITY_GDE}', ''),
(8, 'users', 'wedding', '*', 'Съемка свадьбы с квадрокотера {CITY_GDE}', '');