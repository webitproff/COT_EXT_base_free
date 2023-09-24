<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.loop
[END_COT_EXT]
==================== */

if($p == 'paypro' && $row['config_name'] == 'offerslimit'){
	$t->assign(array(
		'ADMIN_CONFIG_ROW_CONFIG' => $row['config_value']." (block by PayOffer)"
		));
}
