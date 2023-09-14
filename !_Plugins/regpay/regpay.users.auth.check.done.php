<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if($cfg['plugin']['regpay']['summ'] > 0)
{
	require_once cot_langfile('regpay', 'plug');

	$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$ruserid)->fetch();

	if($urr['user_logcount'] == 1)
	{
		$payinfo['pay_userid'] = $urr['user_id'];
		$payinfo['pay_area'] = 'balance';
		$payinfo['pay_code'] = 'register';
		$payinfo['pay_summ'] = $cfg['plugin']['regpay']['summ'];
		$payinfo['pay_cdate'] = $sys['now'];
		$payinfo['pay_pdate'] = $sys['now'];
		$payinfo['pay_adate'] = $sys['now'];
		$payinfo['pay_status'] = 'done';
		$payinfo['pay_desc'] = $L['regpay_payments_desc'];

		if($db->insert($db_payments, $payinfo))
		{
			cot_mail($urr['user_email'], $L['regpay_mail_subject'], sprintf($L['regpay_mail_body'], $urr['user_name']));
			cot_log("Payment for register");
			/* === Hook === */
	                foreach (cot_getextplugins('regpay.done') as $pl)
	                {
		            include $pl;
	                }
	                /* ===== */
		}
	}
}
