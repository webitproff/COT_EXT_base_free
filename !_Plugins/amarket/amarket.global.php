<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

require_once cot_incfile('amarket', 'plug');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату.
if ($payamarket = cot_payments_getallpays('amarket', 'paid'))
{
	foreach ($payamarket as $pay)
	{	
		$userid = $pay['pay_userid'];
		$paycode = $pay['pay_code'];
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_amarket_orders, array("amo_status" => 3), "amo_id=".(int)$paycode);
			$amo_price = cot_amo_get_price($paycode);
			$amo_opt['pay_userid'] = $db->query("SELECT amo_seller FROM {$db_amarket_orders} WHERE amo_id=?",$paycode)->fetchColumn();
			$amo_opt['pay_area'] = 'balance';
			$amo_opt['pay_summ'] = $amo_price['amo_seller_cost'];
			$amo_opt['pay_cdate'] = $amo_opt['pay_pdate'] = $amo_opt['pay_adate'] = $sys['now'];
			$amo_opt['pay_status'] = 'done';
			$amo_opt['pay_desc'] = cot_rc($L['amarket_pay_desc'], array('id' => $pay['pay_code']));
			$amo_opt['pay_code'] = 'amarket:'.$pay['pay_code'];
			$db->insert($db_payments, $amo_opt);	
			cot_am_notif($pay['pay_code']);
			/* === Hook === */
			foreach (cot_getextplugins('payamarket.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}
