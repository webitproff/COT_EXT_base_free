<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rc
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['ds']['sound']) {
cot_rc_link_file($cfg['modules_dir'] . '/ds/js/ion.sound.min.js'); 
}

cot_rc_link_file($cfg['modules_dir'] . '/ds/tpl/ds.css');
cot_rc_link_file($cfg['modules_dir'] . '/ds/js/ds.js');


if ($cfg['ds']['ajaxcheck']) {
cot_rc_link_file($cfg['modules_dir'] . '/ds/js/ajaxcheck.js'); 
}

if ($cfg['ds']['turnajax']) {
cot_rc_link_file($cfg['modules_dir'] . '/ds/js/ds.ajax.js');
}
                             