<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rc
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$ajaxpopover_framework = $cfg['plugin']['ajaxpopover']['framework'];

if ($cfg['plugin']['ajaxpopover']['framework'] == 'custom')
{
  cot_rc_add_file($cfg['plugins_dir'] . '/ajaxpopover/js/ajaxpopover.popover.js');
  cot_rc_add_file($cfg['plugins_dir'] . '/ajaxpopover/css/ajaxpopover.popover.css');

  $ajaxpopover_framework = 'bootstrap';
}

cot_rc_add_file($cfg['plugins_dir'] . '/ajaxpopover/js/ajaxpopover.'.$ajaxpopover_framework.'.js');

if ($ajaxpopover_framework == 'bootstrap' && $cfg['plugin']['ajaxpopover']['bootstrappopovercss'])
{
  cot_rc_add_file($cfg['plugins_dir'] . '/ajaxpopover/css/ajaxpopover.bootstrap.popover.css');
}
