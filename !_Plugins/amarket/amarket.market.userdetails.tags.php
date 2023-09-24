<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=market.userdetails.tags
Tags=market.userdetails.tpl:{USERS_AMARKET_CART}
[END_COT_EXT]
==================== */

if((int)$usr['maingrp'] == (int)$cfg['plugin']['amarket']['am_custumer_id'] && $usr['id'] != $urr['user_id']){	
	$opt_arr_url['m'] = "details";
	$opt_arr_url['id'] = $id;
	$opt_arr_url['u'] = $u;
	$opt_arr_url['tab'] = "market";
	$opt_arr_url['d'] = $d;
	$opt_arr_url['cat'] = $category;

	$tc = new XTemplate(cot_tplfile(array('amarket','cart'), 'plug'));

	$cookieData = unserialize($_COOKIE['cart']);

	if($cookieData[$urr['user_id']]){

		$totalprice = 0;
		foreach ($cookieData[$urr['user_id']] as $prd_id => $count) {

			$prd_data = $db->query("SELECT * FROM {$db_market} WHERE item_id = '" . (int)$prd_id . "' LIMIT 1")->fetch();
			$totalprice += $costforneedcount = $prd_data['item_cost'] * $count;
			$url_add = cot_url('users', array_merge($opt_arr_url,array('a' => 'prd_add_count', 'prd_id' => $prd_id, 'x' => $sys['xk'])));
			$url_delete = cot_url('users', array_merge($opt_arr_url,array('a' => 'prd_delete_count', 'prd_id' => $prd_id, 'x' => $sys['xk'])));

			$opt_arr_url['cart'] = 'delete';
			$opt_arr_url['prd_id'] = $prd_id;
			$opt_arr_url['x'] = $sys['xk'];

			$tc->assign(array(
				"ROW_PRD_NEEDCOUNT" => cot_rc('amarket_edit_count', array('id' => $prd_id, 'prd_count' => $count, 'url_add' => $url_add, 'url_delete' => $url_delete)),
				"ROW_PRD_COSTFORNEEDCOUNT" => number_format($costforneedcount, '2', '.', ' '),
				"ROW_PRD_DELETE" => cot_url('users', $opt_arr_url,'#cart', true)
			));
			$tc->assign(cot_generate_markettags($prd_data,'ROW_PRD_'));
			$tc->parse("MAIN.ROW");
		}

	}

	// Extra fields
	if (isset($cot_extrafields[$db_amarket_orders]))
	{		
		foreach($cot_extrafields[$db_amarket_orders] as $exfld)
		{
			$uname = strtoupper($exfld['field_name']);
			$exfld_val = cot_build_extrafields('amo_'.$exfld['field_name'], $exfld, $ramarket['amo_'.$exfld['field_name']]);
			$exfld_title = isset($L['amarket_'.$exfld['field_name'].'_title']) ?  $L['amarket_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
			$tc->assign(array(
				'USERS_AMARKET_'.$uname => $exfld_val,
				'USERS_AMARKET_'.$uname.'_TITLE' => $exfld_title,
				'USERS_AMARKET_EXTRAFLD' => $exfld_val,
				'USERS_AMARKET_EXTRAFLD_TITLE' => $exfld_title
				));
			$tc->parse("MAIN.EXTF_ROW");
		}
	}	

	$commission = $totalprice * $cfg['plugin']['amarket']['am_from_customer']/100;
	$totalsumm = $totalprice + $commission;


	$tc->assign(array(
		"USERS_AMARKET_PRODUCTS_COUNT" => count($cookieData[$urr['user_id']]),
		"USERS_AMARKET_CART_ACTION" => cot_url('users',$opt_arr_url, '', true),
		"USERS_AMARKET_TOTALPRICE" => number_format($totalsumm, '2', '.', ' '),
		"USERS_AMARKET_COMMISSION" => number_format($commission, '2', '.', ' '),
	));
	cot_display_messages($tc);
	$tc->parse("MAIN");

	$t1->assign(array(
		"USERS_AMARKET_CART" =>$tc->text("MAIN"),
	));
}