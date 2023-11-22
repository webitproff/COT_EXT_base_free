<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('seo', 'plug');

global $db_seo;

if ($db->fieldExists($db_seo, "seo_lang"))
{
    $db->addIndex($db_seo, 'seo_lang', 'seo_lang');
}