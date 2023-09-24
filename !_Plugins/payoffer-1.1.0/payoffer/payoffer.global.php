<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

require_once cot_incfile('payoffer', 'plug');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату тарифов.
if ($payoffer = cot_payments_getallpays('payoffer', 'paid'))
{
	//Завантаження конфігурацій тарифів
	$tariff = cot_po_load_config();

	foreach ($payoffer as $pay)
	{	
		$userid = $pay['pay_userid'];
		$paycode = $pay['pay_code'];
		if(array_key_exists($paycode, $tariff)){
			$payoffercount = $tariff[$paycode]['count'];
		}else{
			cot_diefatal('Wrong payments offer code .');
		}

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->query("UPDATE {$db_users} SET user_payoffer=user_payoffer+{$payoffercount} WHERE user_id={$userid}");
			/* === Hook === */
			foreach (cot_getextplugins('payoffer.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}