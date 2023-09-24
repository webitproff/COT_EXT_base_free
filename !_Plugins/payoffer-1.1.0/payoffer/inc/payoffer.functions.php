<?php defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('payoffer', 'plug');
require_once cot_incfile('payoffer', 'plug', 'resources');

// Завантаження конфігурації тарифних планів
// Якщо увімкнений PayPro і вказана знижка - вираховується додатково
function cot_po_load_config(){
	global $cfg;
	$param = array();
	$parsecfgtmp = str_replace("\r\n", "\n", $cfg['plugin']['payoffer']['po_config']);
	$parsecfg = explode("\n", $parsecfgtmp);
	foreach ($parsecfg as $lineset)
	{
		if(empty($lineset)) continue; 
		list($offer_code,$offer_count,$offer_cost) = explode("|", $lineset);
		$offer_code  = (string)trim($offer_code);
		$param[$offer_code]['count'] = (float)$offer_count;
		$param[$offer_code]['cost'] = round((float)$offer_cost, 2);

		if(cot_plugin_active('paypro')){
			$pro_discount = (float)$cfg['plugin']['payoffer']['po_pro_discount'];
			if(!empty($pro_discount) && $pro_discount > 0){
					$param[$offer_code]['pro_cost'] = round($param[$offer_code]['cost'] - ($param[$offer_code]['cost'] * $pro_discount / 100),2);
			}
		}
	}
	if(count($param) > 0){
		return $param;
	}
		return false;
}

// Отримуємо залишок публікацій користувача
function cot_po_getuseroffercount($user_id){
	global $db, $db_users, $L;
	
	$user_id = (int)$user_id;

	if($user_id <= 0){
		return false;
	}

	$result = $db->query("SELECT user_payoffer FROM {$db_users} WHERE user_id={$user_id} LIMIT 1")->fetchColumn();

	if($result < 0){
		return 0;
	}

	return $result;
}
// Оновлення ліміту публікацій
function cot_po_addoffer($user_id,$count=1){
	global $db, $db_users, $usr, $L;

	$user_id = (is_int($user_id) && $user_id > 0) ? $user_id : $usr['id'];
	
	$result = $db->query("UPDATE {$db_users} SET user_payoffer = user_payoffer-{$count} WHERE user_id={$user_id} LIMIT 1");

	if($result){
		return cot_po_getuseroffercount($user_id);
	}
	return false;
}