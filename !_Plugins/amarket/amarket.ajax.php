<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

cot_blockguests();

require_once cot_incfile('amarket', 'plug');
/*
* Можна змінити статус тільки в такій послідовності 1 -> 2, 1 -> 4, 2 -> 3, 2 -> 4
*/
$s = cot_import('s', 'G', 'TXT');
$amo_id = cot_import('amo_id', 'G', 'INT');
cot_block($amo_id);
cot_check_xg();
$amo_data = $db->query("SELECT amo_seller, amo_customer FROM {$db_amarket_orders} WHERE amo_id=?",$amo_id)->fetch();
if(COT_AJAX){
	if ($m == 'mysales' && $amo_data['amo_seller'] == $usr['id']) {
		//потрібна перевірка на продавця
		if($s == 'cancel'){
			if (!$db->update($db_amarket_orders, array('amo_status' => 4, 'amo_change' => $sys['now']), 'amo_id = ? AND amo_status = 1 LIMIT 1', $amo_id))
			{
				cot_log('Error change status to 4 on #'.$amo_id, 'adm');
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error']));
			}else{
				//email notif
				cot_am_notif($amo_id,$m);
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_warning']));
			}
			exit;
		}
		if($s == 'confirm') {
			if (!$db->update($db_amarket_orders, array('amo_status' => 2, 'amo_change' => $sys['now']), 'amo_id = ? AND amo_status = 1 LIMIT 1', $amo_id))
			{
				cot_log('Error change status to 2 on #'.$amo_id, 'adm');
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error']));
			}else{
				//email notif
				cot_am_notif($amo_id);
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_succses']));
			}
			exit;
		}
		if($s == 'invisible') {
			if (!$db->update($db_amarket_orders, array('amo_invisible_seller' => 1), 'amo_id = ? AND (amo_status = 4 OR amo_status = 3) LIMIT 1', $amo_id))
			{
				cot_log('Error hidden for on #'.$amo_id, 'adm');
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error']));
			}else{
				echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_hidden']));
			}
			exit;
		}
	}

	if($m == 'myorders' && $amo_data['amo_customer'] == $usr['id']){
		//потрібна перевірка на покупця
		 if($s == 'cancel'){
		 	if (!$db->update($db_amarket_orders, array('amo_status' => 4, 'amo_change' => $sys['now']), 'amo_id = ? AND amo_status = 2 LIMIT 1', $amo_id))
		 	{
		 		cot_log('Error change status to 4 on #'.$amo_id, 'adm');
		 		echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error']));
		 	}else{
		 		//email notif
		 		cot_am_notif($amo_id,$m);
		 		echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_warning']));
		 	}
		 	exit;
		 }
		 if($s == 'invisible') {
			 if (!$db->update($db_amarket_orders, array('amo_invisible_customer' => 1), 'amo_id = ? AND (amo_status = 4 OR amo_status = 3) LIMIT 1', $amo_id))
			 {
				 cot_log('Error hidden for on #'.$amo_id, 'adm');
				 echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_error']));
			 }else{
				 echo cot_rc('amarket_list_change_status', array('text' => $L['amarket_change_status_hidden']));
			 }
			 exit;
		 }

	}

}
