<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('seo', 'plug');

global $db_seo;

if (!$db->fieldExists($db_seo, "seo_desc"))
{
    $db->query("ALTER TABLE `$db_seo` ADD COLUMN `seo_desc` varchar(255) collate utf8_unicode_ci DEFAULT ''");
}