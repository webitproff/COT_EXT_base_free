<?php defined('COT_CODE') or die('Wrong URL');


$out['subtitle'] = cot_am_title($m,$n);

cot_blockguests();

if ($a == 'pay')
{
	cot_check_xp();		

	cot_check(!$amo_id, 'Error');

	if (!cot_error_found()){
		$amo_price = cot_amo_get_price($amo_id);
		$options['desc'] = cot_rc($L['amarket_pay_desc'], array('id' => $amo_id));
		$options['code'] = $amo_id; 

		if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
		}
		
		cot_payments_create_order('amarket', $amo_price['amo_customer_cost'], $options);
	}
	cot_redirect(cot_url('amarket', 'm=pay&amo_id=15', '', true));
}



$patharray[] =  array(cot_url('amarket'),$L['amarket_myorders_title']);
$patharray[] = array(cot_url('amarket', array('m' => 'myorders', 'n' => 'waitpayment')),$L['amarket_status_forpayment_title']);
$patharray[] = array('',$L["amarket_{$m}_title"] . ' #'.$amo_id);

$t = new XTemplate(cot_tplfile("amarket.{$m}", "plug"));

$sqlarray = $db->query("SELECT * FROM {$db_amarket_orders} WHERE amo_customer =".(int)$usr['id']." AND amo_id={$amo_id}")->fetch();

if($sqlarray){
	$prd_list = $db->query("SELECT m.item_alias, m.item_cat, m.item_id, m.item_title, m.item_cost, am.amp_prd_count FROM {$db_amarket_products} AS am LEFT JOIN {$db_market} AS m ON m.item_id = am.amp_prd_id WHERE am.amo_id = ".$sqlarray['amo_id'])->fetchAll();
	
	$amo_cost = 0;
	foreach ($prd_list as $item_data) {	
		$amo_cost += $item_data['item_cost'] * $item_data['amp_prd_count'];

		$url = (empty($item_data['item_alias'])) ? 
		 cot_url('market', 'c='.$item_data['item_cat'].'&id='.$item_data['item_id']) : cot_url('market', 'c='.$item_data['item_cat'].'&al='.$item_data['item_alias']);
		$t->assign(array(
			"PRD_TITLE" => cot_rc_link($url, $item_data['item_title']),
			"PRD_COUNT" => $item_data['amp_prd_count'],
			"PRD_COST" => number_format($item_data['item_cost'], '2', '.', ' '),
			"PRD_COST_SUMM" => number_format($item_data['amp_prd_count'] * $item_data['item_cost'], '2', '.', ' '),
			));
		$t->parse("MAIN.PRD");
	}	
	$commission = $amo_cost*$cfg['plugin']['amarket']['am_from_customer']/100;
	$totalsumm = $amo_cost + $commission;


}
$t->assign("BREADCRUMBS", cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true));
$t->assign(array(
		"AM_CLEAR_COST" => number_format($amo_cost, '2', '.', ' '),
		"AM_COST" => number_format($totalsumm, '2', '.', ' '),
		"AM_COMM" => number_format($commission, '2', '.', ' '),
		"AM_FORM_ACTION" => cot_url('amarket', array('m' => 'pay', 'a' => 'pay', 'amo_id' => $amo_id))
	));

//повідомлення
cot_display_messages($t);