<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('paycontacts', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'paycontacts');
cot_block($auth_write);

if ($a == 'buy' && $usr['id'] > 0)
{
	$months = cot_import('months', 'P', 'INT');
	
	cot_check(empty($months), 'paycontacts_error_months');
	
  $user = $db->query("SELECT * FROM $db_users WHERE user_id = ".$usr['id']." LIMIT 1")->fetch();
	
	if (!cot_error_found())
	{
		$summ = $months * $cfg['plugin']['paycontacts']['cost'];
		$options['time'] = $months * 30 * 24 * 60 * 60;
		$options['desc'] = $L['paypaycontacts_buy_paydesc'];
		$options['code'] = $usr['id'];
		
		if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
		}
		
		cot_payments_create_order('paycontacts', $summ, $options);
	}
}

$t = new XTemplate(cot_tplfile('paycontacts', 'plug'));

cot_display_messages($t);

$t->assign(array(
	'PAY_FORM_ACTION' => cot_url('plug', 'e=paycontacts&a=buy&id='),
	'PAY_FORM_PERIOD' => cot_selectbox('', 'months', range(1, 12), range(1, 12), false),
));

?>