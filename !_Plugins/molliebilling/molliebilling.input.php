<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=input
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

$r = cot_import('r', 'G', 'ALP');
$e = cot_import('e', 'G', 'ALP');

if ($r == 'molliebilling' || $e == 'molliebilling')
{
	$cfg['referercheck'] = false;
	define('COT_NO_ANTIXSS', TRUE);
}
?>