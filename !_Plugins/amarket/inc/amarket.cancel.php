<?php defined('COT_CODE') or die('Wrong URL');

$out['subtitle'] = cot_am_title($m,$n);

cot_blockguests();

if((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_seller_id']){
	$where = " amo_seller = ".(int)$usr['id'];
	$redirect_url = cot_url('amarket','m=mysales&n=forconfirm', '', true);
	$for_notif = 'mysales';
	$patharray[] = array(cot_url('amarket'), $L["amarket_mysales_title"]);
	$patharray[] = array(cot_url('amarket', array('m' => 'mysales', 'n' => 'forconfirm')),$L['amarket_status_forconfirm_title']);
}

if((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_custumer_id']){
	$where = " amo_customer = ".(int)$usr['id'];
	$redirect_url = cot_url('amarket','m=myorders&n=waitpayment', '', true);
	$for_notif = 'myorders';
	$patharray[] =  array(cot_url('amarket'),$L['amarket_myorders_title']);
	$patharray[] = array(cot_url('amarket', array('m' => 'myorders', 'n' => 'waitpayment')),$L['amarket_status_forpayment_title']);
}

if ($a == 'cancel')
{
	cot_check_xp();		

	$ramarket['amo_cancel_reason'] = cot_import('amo_cancel_reason', 'P', 'HTM');

	cot_check(!$amo_id, 'Error');
	cot_check(mb_strlen($ramarket['amo_cancel_reason']) < 1, $L['amarket_cancel_reason_short'],'amo_cancel_reason');
	if (!cot_error_found()){	

		$ramarket['amo_status'] = 4;
		$ramarket['amo_change'] = $sys['now'];

		if($db->update($db_amarket_orders,$ramarket, $where." AND amo_id=?", $amo_id)){
			cot_log('Error change status to 4 on #'.$amo_id, 'adm');
			cot_am_notif($amo_id,$for_notif);
			cot_message('amarket_change_status_warning', 'ok');
			cot_redirect($redirect_url);
		}
		
	}
	
}


if(!$db->query("SELECT * FROM {$db_amarket_orders} WHERE ".$where." AND amo_id={$amo_id} AND (amo_status = 1 OR amo_status = 2)")->fetch()){
	cot_die();
}

$patharray[] = array('',$L["amarket_{$m}_title"] . ' #'.$amo_id);

$t = new XTemplate(cot_tplfile("amarket.{$m}", "plug"));

$t->assign("BREADCRUMBS", cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true));
$t->assign(array(
		"CANCEL_FORM_TEXT" => cot_textarea('amo_cancel_reason', $ramarket['amo_cancel_reason'], 5, 56),
		"CANCEL_FORM_URL" => cot_url('amarket', array('m' => 'cancel', 'a' => 'cancel', 'amo_id' => $amo_id))
	));

//повідомлення
cot_display_messages($t);