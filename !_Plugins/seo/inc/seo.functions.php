<?php

defined('COT_CODE') or die('Wrong URL');

// Registering tables and fields
cot::$db->registerTable('seo');

function getSeoData($area, $cat = '', $city = '')
{

    global $db, $db_seo, $cfg;
    if ($cat == '' && $city == '') {
        $seo = $db->query("SELECT * FROM $db_seo 
			WHERE seo_lang='" . $cfg['defaultlang'] . "' AND seo_area='" . $area . "' AND seo_category='' AND seo_city='' LIMIT 1")->fetch();
    } elseif (!empty($cat) && $city == '') {
        $seo = $db->query("SELECT * FROM $db_seo 
			WHERE seo_lang='" . $cfg['defaultlang'] . "' AND seo_area='" . $area . "' AND (
					(seo_category='" . $cat . "' AND seo_city='') OR 
					(seo_category='" . $cat . "' AND seo_city='*') OR 
					(seo_category='*' AND seo_city='')
				) 
			ORDER BY seo_id DESC LIMIT 1")->fetch();
    } elseif ($cat == '' && $city > 0) {
        $seo = $db->query("SELECT * FROM $db_seo 
			WHERE seo_lang='" . $cfg['defaultlang'] . "' AND seo_area='" . $area . "' AND (
					(seo_category='' AND seo_city='" . $city . "') OR 
					(seo_category='*' AND seo_city='" . $city . "') OR 
					(seo_category='' AND seo_city='*')
				) 
			ORDER BY seo_id DESC LIMIT 1")->fetch();
    }
    if (empty($seo)) {
        $seo = $db->query("SELECT * FROM $db_seo 
			WHERE seo_lang='" . $cfg['defaultlang'] . "' AND seo_area='" . $area . "' AND (
					(seo_category='" . $cat . "' AND seo_city='" . $city . "') OR 
					(seo_category='" . $cat . "' AND seo_city='*') OR 
					(seo_category='*' AND seo_city='" . $city . "') OR 
					(seo_category='*' AND seo_city='*')
				) 
			ORDER BY seo_id DESC LIMIT 1")->fetch();
    }

    return $seo;
}