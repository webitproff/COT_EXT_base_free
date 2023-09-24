<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=market.userdetails.loop
Tags=market.userdetails.tpl:{PRD_ROW_AMARKET_CART_ACTION_URL},{PRD_ROW_AMARKET_CART_TITLE}
[END_COT_EXT]
==================== */
if((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_custumer_id']){	

	$opt_array['prd_id'] = $item['item_id'];
	$opt_array['cart'] = 'add';

	$cookieData = unserialize($_COOKIE['cart']);

	if($cookieData[$urr['user_id']][$item['item_id']]){
		$opt_array['cart'] = 'delete';
	}
	$opt_array['x'] = $sys['xk'];

	$t1->assign(array(
	    "PRD_ROW_AMARKET_CART_ACTION_URL" => cot_url('users',$opt_array),
	    "PRD_ROW_AMARKET_CART_TITLE"	=> ($opt_array['cart'] == "delete") ? $L['Delete'] : $L['Add'],
		));
	unset($opt_array['x']);
}

