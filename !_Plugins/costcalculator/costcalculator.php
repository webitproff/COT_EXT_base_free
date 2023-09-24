<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

require_once cot_incfile('costcalculator', 'plug');

if (!in_array($m, array('fill', 'edit'))){

	if (isset($_GET['id'])){
		$m = 'main';
	}else{
		$m = 'list';
	}
}

require_once cot_incfile('costcalculator', 'plug', $m);
