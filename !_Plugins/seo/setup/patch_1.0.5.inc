<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('seo', 'plug');

global $db_seo;

if (!$db->fieldExists($db_seo, "seo_lang"))
{
    $db->query("ALTER TABLE `$db_seo` ADD COLUMN `seo_lang` varchar(2) collate utf8_unicode_ci DEFAULT 'ru' AFTER `seo_id`");
}