<?php defined('COT_CODE') or die('Wrong URL');


$out['subtitle'] = cot_am_title($m,$n);

cot_blockguests() || cot_block((int)$cfg['plugin']['amarket']['am_seller_id'] == (int)$usr['maingrp']);

//пагінація
$maxrowsperpage = $cfg['plugin']['amarket']['am_maxperpage'];
list($pn, $d, $d_url) = cot_import_pagenav('d', $maxrowsperpage);
$sort = cot_import('sort', 'G', 'TXT');
if($sort == 'asc' || $sort == 'desc'){
	$sql_sort = " ORDER BY amo_added {$sort}";
}else{
 	$sql_sort = " ORDER BY amo_added ASC";
}
$t = new XTemplate(cot_tplfile("amarket.{$m}", "plug"));

if($n == "forconfirm"){
	$id_status = 1;
	$invisible = ' AND amo_invisible_seller <> 1';
}elseif($n == "waitpayment"){
	$id_status = 2;
	$invisible = ' AND amo_invisible_seller <> 1';
}elseif($n == "paid"){
	if($a == 'invisible' && cot_check_xg()){ 
		cot_amo_hide($m,$n,$usr['id']); 
	}
	$id_status = 3;
	$invisible = ' AND amo_invisible_seller <> 1';
}elseif($n == "cancelled"){
	if($a == 'invisible' && cot_check_xg()){ 
		cot_amo_hide($m,$n,$usr['id']); 
	}
	$id_status = 4;
	$invisible = ' AND amo_invisible_seller <> 1';
}else{
	cot_die();
}

$patharray[] = array(cot_url('amarket'), $L["amarket_{$m}_title"]);

$l = new XTemplate(cot_tplfile("amarket.{$m}.list", "plug"));

$sqlarray = $db->query("SELECT * FROM {$db_amarket_orders} WHERE amo_status = {$id_status} AND amo_seller =".(int)$usr['id']." {$invisible} {$sql_sort} LIMIT {$d}, " . $maxrowsperpage)->fetchAll();
$totalitems = $db->query("SELECT COUNT(*) as total FROM {$db_amarket_orders} WHERE amo_status = {$id_status} {$invisible} AND amo_seller =".(int)$usr['id'])->fetchColumn();

$odd = 0;
foreach ($sqlarray as $row) {

	$prd_list = $db->query("SELECT m.item_alias, m.item_cat, m.item_id, m.item_title, m.item_cost, am.amp_prd_count FROM {$db_amarket_products} AS am LEFT JOIN {$db_market} AS m ON m.item_id = am.amp_prd_id WHERE am.amo_id = ".$row['amo_id'])->fetchAll();

	$amo_cost = 0;
	foreach ($prd_list as $item_data) {
		$url = (empty($item_data['item_alias'])) ?
		 cot_url('market', 'c='.$item_data['item_cat'].'&id='.$item_data['item_id']) : cot_url('market', 'c='.$item_data['item_cat'].'&al='.$item_data['item_alias']);
		$amo_cost += $item_data['item_cost']*$item_data['amp_prd_count'];

		$l->assign(array(
			"PRD_TITLE" => cot_rc_link($url, $item_data['item_title']),
			"PRD_COUNT" => $item_data['amp_prd_count'],
			"PRD_COST" => number_format($item_data['item_cost'], '2', '.', ' '),
			"PRD_COST_SUMM" => number_format($item_data['amp_prd_count'] * $item_data['item_cost'], '2', '.', ' '),
			));
		$l->parse("MAIN.ROW.PRD");
	}


	if($n == "forconfirm"){
		if($cfg['plugin']['amarket']['am_enablereason']){
			$cancel_url = cot_url('amarket', 'm=cancel&amo_id='.$row['amo_id']);
			$cancel_bnt = cot_rc_link($cancel_url,$L['Cancel_order'],"class='btn btn-danger'");
		}else{
			$cancel_url = cot_url('index', 'r=amarket&m=mysales&s=cancel&amo_id='.$row['amo_id']."&".cot_xg(),'',true);
			$cancel_bnt = cot_rc('amarket_btn_change_status_cancel', array('url' => $cancel_url, 'id' => $row['amo_id'], 'text' => $L['Cancel_order']));
		}
		$confirm_url = cot_url('index', 'r=amarket&m=mysales&s=confirm&amo_id='.$row['amo_id']."&".cot_xg(),'',true);
		$confirm_btn = cot_rc('amarket_btn_change_status_confirm', array('url' => $confirm_url, 'id' => $row['amo_id'], 'text' => $L['Confirm_order']));
	}

	if($n == "cancelled" || $n == "paid"){
		$invisible_btn_url =  cot_url('index', 'r=amarket&m=mysales&s=invisible&amo_id='.$row['amo_id']."&".cot_xg(),'',true);
		$invisible_btn = cot_rc('amarket_btn_change_status_cancel', array('url' => $invisible_btn_url, 'id' => $row['amo_id'], 'text' => $L['Clear_order']));		
	}

	$commission = $amo_cost*$cfg['plugin']['amarket']['am_from_seller']/100;
	$totalsumm = $amo_cost - $commission;
	$l->assign(array(
		"AMO_ID" 				=> $row['amo_id'],
		"AMO_ADDED_TIMESTAMP" 	=> $row['amo_added'],
		"AMO_ADDED" 			=> cot_date('datetime_medium', $row['amo_added']),
		"AMO_CHANGE_TIMESTAMP" 	=> ($row['amo_change']) ? $row['amo_change'] : '-',
		"AMO_CHANGE" 			=> ($row['amo_change']) ? cot_date('datetime_medium', $row['amo_change']) : '-',
		"AMO_STATUS"			=> cot_am_get_status($row['amo_status']),
		"AMO_STATUS_ID" 		=> $row['amo_status'],
		"AMO_COST"				=> number_format($amo_cost, '2', '.', ' '),
		"AMO_COMMISSION"		=> number_format($commission, '2', '.', ' '),
		"AMO_COST_WC"			=> number_format($totalsumm, '2', '.', ' '),
		"AMO_ODDEVEN" 			=> cot_build_oddeven($odd++),
		"AMO_CANCEL_REASON"		=> $row['amo_cancel_reason'],
		"AMO_CANCEL_BTN"		=> $cancel_bnt,
		"AMO_CONFIRM_BTN"		=> $confirm_btn,
		"AMO_LIST_EDIT_URL"		=> cot_url('amarket', 'm=list&n=edit&amo_id='.$row['amo_id']),
		"AMO_INVISIBLE_BTN" 	=> $invisible_btn
		));
	$l->assign(cot_generate_usertags($row['amo_seller'], 'AMO_SELLER_'));
	$l->assign(cot_generate_usertags($row['amo_customer'], 'AMO_CUSTOMER_'));

		// Extra fields
	if (isset($cot_extrafields[$db_amarket_orders]))
	{
		foreach ($cot_extrafields[$db_amarket_orders] as $exfld)
		{
			$uname = strtoupper($exfld['field_name']);
			$exfld_val = cot_build_extrafields_data('amo_' . $exfld['field_name'], $exfld, $row['amo_' . $exfld['field_name']]);
			$exfld_title =  isset($L['amarket_' . $exfld['field_name'] . '_title']) ? $L['amarket_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
			$l->assign(array(
				'AMO_' . $uname => $exfld_val,
				'AMO_' . $uname . '_TITLE' => $exfld_title,
				'AMO_AMARKET_EXTRAFLD' => $exfld_val,
				'AMO_AMARKET_EXTRAFLD_TITLE' => $exfld_title
				));
			$l->parse("MAIN.ROW.EXTF_ROW");
		}
	}

	$l->parse("MAIN.ROW");
}
if(($n == "cancelled" || $n == "paid") && $totalitems > 0){
	$invisible_btn_all_url = cot_url('amarket', 'm=mysales&n='.$n.'&a=invisible&'.cot_xg(),'',true);
	$invisible_btn_all = cot_rc_link($invisible_btn_all_url, $L['Clear_order_all'], "class='btn btn-danger'");
	$l->assign("AMO_INVISIBLE_BTN_ALL", $invisible_btn_all);
}
$sort_btn = cot_rc('amarket_link_sort', array(
		'asc_url' => cot_url('amarket', array('m' => $m, 'n' => $n, 'd' => $d, 'sort' => 'asc')),
		'desc_url' => cot_url('amarket', array('m' => $m, 'n' => $n, 'd' => $d, 'sort' => 'desc'))
	));

$l->assign("AMO_SORT", $sort_btn);

$l->parse("MAIN");



$t->assign("BREADCRUMBS", cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true));
$t->assign("AMARKET", $l->text('MAIN'));

//пагінація
$list_url_path = array ('e' => 'amarket', 'n' => $n);
$pagenav = cot_pagenav('amarket', $list_url_path, $d, $totalitems, $maxrowsperpage);
$orders_count = $db->query("SELECT amo_status, COUNT(amo_status) as total  FROM {$db_amarket_orders} WHERE amo_seller =".(int)$usr['id']." {$invisible} GROUP BY amo_status")->fetchAll(PDO::FETCH_GROUP);
$t->assign(array(
	"PAGENAV_PAGES" 				=> $pagenav['main'],
	"PAGENAV_PREV" 					=> $pagenav['prev'],
	"PAGENAV_NEXT" 					=> $pagenav['next'],
	"PAGENAV_ONPAGE" 				=> $pagenav['onpage'],
	"PAGENAV_COUNT" 				=> $totalitems,
	'AMARKET_MYSALES_FORCONFIRM' 	=> cot_url('amarket', 'm=mysales&n=forconfirm'),
	'AMARKET_MYSALES_WAITPAYMENT'	=> cot_url('amarket', 'm=mysales&n=waitpayment'),
	'AMARKET_MYSALES_PAID' 			=> cot_url('amarket', 'm=mysales&n=paid'),
	'AMARKET_MYSALES_CANCELLED' 	=> cot_url('amarket', 'm=mysales&n=cancelled'),
	'AMARKET_MYSALES_FORCONFIRM_COUNT' 	=> ($orders_count['1']) ? $orders_count['1'][0]['total'] : 0 ,
	'AMARKET_MYSALES_WAITPAYMENT_COUNT'	=> ($orders_count['2']) ? $orders_count['2'][0]['total'] : 0 ,
	'AMARKET_MYSALES_PAID_COUNT' 		=> ($orders_count['3']) ? $orders_count['3'][0]['total'] : 0 ,
	'AMARKET_MYSALES_CANCELLED_COUNT' 	=> ($orders_count['4']) ? $orders_count['4'][0]['total'] : 0 ,
	));
//повідомлення
cot_display_messages($t);
