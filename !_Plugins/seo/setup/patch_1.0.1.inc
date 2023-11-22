<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('seo', 'plug');

global $db_seo;

$db->query("ALTER TABLE $db_seo ADD COLUMN `seo_h1` VARCHAR(255) NOT NULL DEFAULT '{PILOTS_READY} к съемке {CATEGORY} {CITY_GDE}'");