<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

if ((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_seller_id']){	
	//forconfirm
	$orders_waitpayment = $db->query("SELECT COUNT(*) FROM {$db_amarket_orders} WHERE amo_status = 1 AND amo_seller =".(int)$usr['id'])->fetchColumn();
	$notify_orders = ($orders_waitpayment > 0) ? array(cot_url('amarket', 'm=mysales&n=forconfirm'), $L['amarket_header_forconfirm_title'] . cot_declension($orders_waitpayment, $Ls['amarket_header_declension'])) : '';
	if (!empty($notify_orders))
	{
		$out['notices_array'][] = $notify_orders;
	}
}
if ((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_custumer_id']){
 	//waitpayment
 	$orders_waitpayment = $db->query("SELECT COUNT(*) FROM {$db_amarket_orders} WHERE amo_status = 2 AND amo_customer =".(int)$usr['id'])->fetchColumn();
 	$notify_orders = ($orders_waitpayment > 0) ? array(cot_url('amarket', 'm=myorders&n=waitpayment'), $L['amarket_header_waitpayment_title'] . cot_declension($orders_waitpayment, $Ls['amarket_header_declension'])) : '';
 	if (!empty($notify_orders))
 	{
 		$out['notices_array'][] = $notify_orders;
 	}
}
