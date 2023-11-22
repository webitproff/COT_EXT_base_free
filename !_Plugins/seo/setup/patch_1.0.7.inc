<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('seo', 'plug');

global $db_seo;

$rules = $db->query("SELECT * FROM $db_seo WHERE seo_lang='ru'")->fetchAll();
foreach ($rules as $rule) {
    unset($rule['seo_id']);
    $rule['seo_lang'] = 'en';

    $db->insert($db_seo, $rule);
}