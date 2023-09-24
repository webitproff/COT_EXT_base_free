<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */
require_once cot_langfile('payorderslist', 'plug');

function cot_get_payorderslist($user_id,$tpl=''){
	global $cfg, $L, $db, $db_payments, $usr;

	$user_id = (!empty($user_id) && is_int($user_id)) ? $user_id : $usr['id'];

	$limit = ((int)$cfg['plugin']['payorderslist']['pol_countlist'] > 0) ? (int)$cfg['plugin']['payorderslist']['pol_countlist'] : 5 ;

	$order = ($cfg['plugin']['payorderslist']['pol_sort'] == 'asc') ? " ORDER BY pay_id ASC" : " ORDER BY pay_id DESC" ;	

	$where = '';

	if($cfg['plugin']['payorderslist']['pol_showonly'] == 'new'){
		$where = " AND pay_status='new'";
	}
	$payorders = $db->query("SELECT * FROM $db_payments WHERE pay_area='payorders' ".$where." AND pay_userid={$user_id} ".$order." LIMIT ".$limit)->fetchAll();
	
	if(count($payorders) > 0){
		$tpol = new XTemplate(cot_tplfile(array('payorderslist', $tpl), 'plug'));
		foreach($payorders as $ord)
		{
			$tpol->assign(cot_generate_paytags($ord, 'LORD_ROW_'));
			$tpol->parse('MAIN.LORD_ROW');
		}		
		$tpol->parse('MAIN');
		return $tpol->text('MAIN');
	}

	return  false;
}