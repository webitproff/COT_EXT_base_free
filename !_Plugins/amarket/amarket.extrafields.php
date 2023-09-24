<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.extrafields.first
[END_COT_EXT]
==================== */
require_once cot_incfile('amarket', 'plug');

$extra_whitelist[$db_amarket_orders] = array(
	'name' => $db_amarket_orders,
	'caption' => $L['Plugin'].' Adv market',
	'type' => 'plug',
	'code' => 'amarket',
	'tags' => array(
		'amarket.mysales.list.tpl' => '{AMO_XXXXX}, {AMO_XXXXX_TITLE}',
		'amarket.myorders.list.tpl' => '{AMO_XXXXX}, {AMO_XXXXX_TITLE}',
		'amarket.cart.tpl' => '{USERS_AMARKET_XXXXX}, {USERS_AMARKET_XXXXX_TITLE}',
		'amarket.list.edit.tpl' => '{EXTFLD_ROW_XXXXX}, {EXTFLD_ROW_XXXXX_TITLE}'
	)
);


