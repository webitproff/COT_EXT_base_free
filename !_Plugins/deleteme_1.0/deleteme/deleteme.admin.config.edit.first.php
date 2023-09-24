<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.first
[END_COT_EXT]
==================== */

if($p == 'deleteme' && $a == 'update' && (float)$_POST['dm_cost'] < 1){
	$_POST['dm_cost'] = 1;
}