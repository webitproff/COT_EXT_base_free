<?php


/* ====================
  [BEGIN_COT_EXT]
  Hooks=global
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('ads', 'plug');
require_once cot_incfile('payments', 'module');

if ($adspays = cot_payments_getallpays('ads', 'paid'))
{
	foreach ($adspays as $pay)
	{	
    $expire = $sys['now'] + $pay['pay_time'];
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_ads,  array('item_expire' => (int)$expire, 'item_begin' => $sys['now']), "item_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payads.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}