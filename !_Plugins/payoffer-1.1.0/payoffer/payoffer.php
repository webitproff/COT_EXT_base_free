<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

require_once cot_incfile('payoffer', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'payoffer');
cot_block($auth_write);

$out['subtitle'] = $L['po_title'];
/* === Hook === */
foreach (cot_getextplugins('payoffer.first') as $pl)
{
	include $pl;
}
/* ===== */

//Завантаження конфігурацій тарифів
$tariff = cot_po_load_config();

if ($a == 'buy')
{	
	$code = cot_import('code', 'G', 'TXT');
	/* === Hook === */
	foreach (cot_getextplugins('payoffer.import') as $pl)
	{
		include $pl;
	}
	/* ===== */
	cot_check_xg();
	cot_check(empty($code) || !is_string($code), 'po_error_code');	
	cot_check(empty($usr['id']) || $usr['id'] <= 0, 'po_error_user');
	cot_check(!array_key_exists($code, $tariff), 'po_error_tariff');
	
	if (!cot_error_found())
	{
		$summ = (cot_getuserpro() && cot_plugin_active('paypro')) ? $tariff[$code]['pro_cost'] : $tariff[$code]['cost'];
		$options['desc'] = cot_rc($L['po_pay_desc'], array('count' => $tariff[$code]['count'])); //Опис в списку витрат
		$options['code'] = $code; //Код тарифу
		
		if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
		}		
		/* === Hook === */
		foreach (cot_getextplugins('payoffer.createorder') as $pl)
		{
			include $pl;
		}
		/* ===== */
		cot_payments_create_order('payoffer', $summ, $options);
	}	
	cot_redirect(cot_url('payoffer'));
}

$t = new XTemplate(cot_tplfile('payoffer', 'plug'));

cot_display_messages($t);

/* === Hook:Part 1 === */
$exp = cot_getextplugins('payoffer.rowtags.loop');
/* ===== */

// Display the main page
foreach ($tariff as $code => $parametr) {
	$t->assign(array(
		'PO_ROW_PAY_URL'  	=> cot_url('payoffer', 'a=buy&code='.$code.'&'.cot_xg()),
		'PO_ROW_PAY_CONFIRM_URL' => cot_confirm_url(cot_url('payoffer', 'a=buy&code='.$code.'&'.cot_xg()), 'payoffer', 'po_pay_confirm'),
		'PO_ROW_CODE'    	=> $code,
		'PO_ROW_COUNT'    	=> $parametr['count'],
		'PO_ROW_COST'    	=> (cot_getuserpro()) ? $parametr['pro_cost'] : $parametr['cost'],
	));
	/* === Hook:Part 2 === */
	foreach ($exp as $pl)
	{
		include $pl;
	}
	/* ===== */
	$t->parse('MAIN.PO_ROW');
}
/* === Hook === */
foreach (cot_getextplugins('payoffer.tags') as $pl)
{
	include $pl;
}
/* ===== */