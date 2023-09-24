<?php defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('amarket', 'plug');
require_once cot_incfile('amarket', 'plug', 'resources');


// Registering tables
cot::$db->registerTable('amarket_products');
cot::$db->registerTable('amarket_orders');

function cot_am_title(&$m, &$n){
	global $L;
	return ($n) ? $L['amarket_'.$m.'_title']." - ".$L['amarket_status_'.$n.'_title'] : $L['amarket_'.$m.'_title'] ;
}

function cot_am_get_status($status_id){
	global $L;
	switch ((int)$status_id) {
		case 1:
			return $L['amarket_status_forconfirm_title'];
			break;
		case 2:
			return $L['amarket_status_forpayment_title'];
			break;
		case 3:
			return $L['amarket_status_paid_title'];
			break;
		case 4:
			return $L['amarket_status_cancelled_title'];
			break;
		default:
			return $L['Error'];
			break;
	}
}

function cot_am_notif($amo_id,$m=''){
	global $db, $db_amarket_orders, $db_users, $cfg, $L;

	if(!$cfg['plugin']['amarket']['am_enablenotif']){
		return false;
	}

	if(!$amo_id){
		return false;
	}

	$info = $db->query("SELECT am.*,
								s.user_name AS seller_name,
								s.user_email AS seller_email,
								c.user_name AS customer_name,
								c.user_email AS customer_email
						FROM {$db_amarket_orders} AS am
						LEFT JOIN {$db_users} AS s ON am.amo_seller = s.user_id
						LEFT JOIN {$db_users} AS c ON am.amo_customer = c.user_id
						WHERE am.amo_id = ?", (int)$amo_id)->fetch();

	switch ($info['amo_status']) {
		case 1:
				$subject = $L['amarket_mail_addorder_titile'];
				$body = cot_rc('amarket_mail_addorder_body', array('user' => $info['customer_name'], 'link' => COT_ABSOLUTE_URL . cot_url('amarket')));
				$to = $info['seller_email'];
			break;
		case 2:
				$subject = $L['amarket_mail_confirm_titile'];
				$body = cot_rc('amarket_mail_confirm_body', array('user' => $info['seller_name'], 'id' => $info['amo_id'], 'link' => COT_ABSOLUTE_URL . cot_url('amarket','m=myorders&n=waitpayment')));
				$to = $info['customer_email'];
			break;
		case 3:
				$subject = $L['amarket_mail_pay_titile'];
				$body = cot_rc('amarket_mail_pay_body', array('user' => $info['customer_name'], 'link' => COT_ABSOLUTE_URL . cot_url('amarket')));
				$to = $info['seller_email'];
			break;
		case 4:
				$user_who_change = ($m == 'mysales') ? $info['seller_name'] : $info['customer_name'] ;
				$link = ($m == 'mysales') ? COT_ABSOLUTE_URL . cot_url('amarket', 'm=mysales&n=cancelled') : COT_ABSOLUTE_URL . cot_url('amarket', 'm=myorders&n=cancelled') ;
				$subject = $L['amarket_mail_cancel_titile'];
				$body = cot_rc('amarket_mail_cancel_body', array('user' => $user_who_change, 'id' => $info['amo_id'], 'link' => $link));
				$to = ($m == 'mysales') ? $info['customer_email'] : $info['seller_email'] ;
			break;
		default:
			# wtf...
			break;
	}

	cot_mail($to, $subject, $body);
}

function cot_amo_get_price($amo_id){
	global $db, $db_amarket_products, $db_market, $cfg;

	if(!$amo_id){
		return false;
	}

	$prd_list = $db->query("SELECT m.item_alias, m.item_cat, m.item_id, m.item_title, m.item_cost, am.amp_prd_count FROM {$db_amarket_products} AS am LEFT JOIN {$db_market} AS m ON m.item_id = am.amp_prd_id WHERE am.amo_id = ?", $amo_id)->fetchAll();

	$amo_cost = 0;
	foreach ($prd_list as $item_data) {
		$amo_cost += $item_data['item_cost'] * $item_data['amp_prd_count'];
	}
	$amo_customer_commission = $amo_cost * $cfg['plugin']['amarket']['am_from_customer']/100;
	$amo_customer_cost = $amo_cost + $amo_customer_commission;

	$amo_seller_commission = $amo_cost * $cfg['plugin']['amarket']['am_from_seller']/100;
	$amo_seller_cost = $amo_cost - $amo_seller_commission;

 	$rtn_data['amo_cost'] = $amo_cost;
 	$rtn_data['amo_seller_cost'] = $amo_seller_cost;
 	$rtn_data['amo_seller_commission'] = $amo_seller_commission;
 	$rtn_data['amo_customer_cost'] = $amo_customer_cost;
 	$rtn_data['amo_customer_commission'] = $amo_customer_commission;

 	return $rtn_data;
}

function cot_amo_get_count($user_id='', $tpl='count'){
		global $db, $db_amarket_products, $db_amarket_orders, $db_market, $cfg, $L;

		require_once cot_incfile('users', 'module');
		$user = cot_user_data($user_id);

		switch ((int)$user['user_maingrp']) {
			case (int)$cfg['plugin']['amarket']['am_seller_id']:
				$where = " amo_seller=".(int)$user['user_id'];
				break;
			case (int)$cfg['plugin']['amarket']['am_custumer_id']:
				$where = " amo_customer=".(int)$user['user_id'];
				break;
			default:
				exit;
				break;
		}

		$orders_count = $db->query("SELECT amo_status, COUNT(amo_status) as total  FROM {$db_amarket_orders} WHERE {$where} GROUP BY amo_status")->fetchAll(PDO::FETCH_GROUP);
		$tpl = $tpl ? $tpl : 'count' ;
		$c = new XTemplate(cot_tplfile("amarket.{$tpl}", "plug"));
		$c->assign(array(
			'AMARKET_FORCONFIRM_COUNT' 	=> ($orders_count['1']) ? $orders_count['1'][0]['total'] : 0 ,
			'AMARKET_WAITPAYMENT_COUNT'	=> ($orders_count['2']) ? $orders_count['2'][0]['total'] : 0 ,
			'AMARKET_PAID_COUNT' 				=> ($orders_count['3']) ? $orders_count['3'][0]['total'] : 0 ,
			'AMARKET_CANCELLED_COUNT' 	=> ($orders_count['4']) ? $orders_count['4'][0]['total'] : 0 ,
			));
		$c->parse("MAIN");
		return $c->text("MAIN");
}

function cot_amo_hide($m, $n, $uid){
	global $db, $db_amarket_orders, $R, $L;

	if(!in_array($m, array('mysales','myorders')) || !in_array($n, array('paid','cancelled')) || (int)$uid < 1){
		return false;
	}

	switch ($n) {
		case 'paid':
			$sql_status = " amo_status = 3";
			break;
		case 'cancelled':
			$sql_status = " amo_status = 4";
			break;
		default:
			exit;
			break;
	}
	switch ($m) {
		case 'mysales':
			$result = $db->update($db_amarket_orders, array('amo_invisible_seller' => 1), "amo_invisible_seller <> 1 AND {$sql_status} AND amo_seller = ?", $uid);
			break;
		case 'myorders':
			$result = $db->update($db_amarket_orders, array('amo_invisible_customer' => 1), "amo_invisible_customer <> 1 AND {$sql_status} AND amo_customer = ?", $uid);
			break;
		default:
			# wtf...
			break;
	}
	 if (!$result) {
	 	cot_message(cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error'])), 'error');	
	 }else{
		cot_message(cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_hidden'])), 'ok');	
	 }

	$param['m'] = $m;
	$param['n'] = $n;
	$redirect = cot_url('amarket', $param, '', true);
	cot_redirect($redirect);
}