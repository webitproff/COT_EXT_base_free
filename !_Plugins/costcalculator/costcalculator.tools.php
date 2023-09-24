<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */
require_once cot_incfile('costcalculator', 'plug');

if (!in_array($n, array('addeditcalc','configcalc')))
{
	$n = 'default';
}
require_once cot_incfile('costcalculator', 'plug', 'tools.'.$n);
