<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paycontacts', 'plug');
require_once cot_incfile('payments', 'module');

if ($paycontactspays = cot_payments_getallpays('paycontacts', 'paid'))
{
	foreach ($paycontactspays as $pay)
	{	
		$userid = (!empty($pay['pay_code'])) ? $pay['pay_code'] : $pay['pay_userid'];
 	  $urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$userid." LIMIT 1")->fetch();
    $upay = $urr['user_paycontacts'];
		$initialtime = ($upay > $sys['now']) ? $upay : $sys['now'];
		$rpayexpire = $initialtime + $pay['pay_time'];

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_users,  array('user_paycontacts' => (int)$rpayexpire), "user_id=".(int)$userid);

          $rbody = cot_rc($L['paypaycontacts_mail_buy_admin'], array(
						'user_name' => $urr['user_name'],
					));
					cot_mail($cfg['adminemail'], $L['paypaycontacts_mail_title_admin'], $rbody);
                                       

          $rbody = cot_rc($L['paypaycontacts_mail_buy_user'], array(
						'user_name' => $urr['user_name'],
					));
					cot_mail($urr['user_email'], $L['paypaycontacts_mail_buy_title_user'], $rbody);
                                                  
			/* === Hook === */
			foreach (cot_getextplugins('paycontacts.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

                                                                                                                                    //20 дней
$userpaycontacts = $db->query("SELECT * FROM $db_users WHERE user_paycontacts>".$sys['now']." AND user_paycontacts<".($sys['now'] + 60*60*24*20)." AND user_paycontacts_sended!=20")->fetchAll();
foreach($userpaycontacts as $urr)
{
 $rbody = cot_rc($L['paypaycontacts_mail_remind'], array(
  'days' => 10,
 ));
 cot_mail($urr['user_email'], $L['paypaycontacts_mail_remind_title'], $rbody);
 
 $db->update($db_users,  array('user_paycontacts_sended' => 20), "user_id=".(int)$urr['user_id']);
}   
unset($userpaycontacts);                                                                                                            //25 дней
$userpaycontacts = $db->query("SELECT * FROM $db_users WHERE user_paycontacts>".$sys['now']." AND user_paycontacts<".($sys['now'] + 60*60*24*25)." AND user_paycontacts_sended!=25")->fetchAll();
foreach($userpaycontacts as $urr)
{
 $rbody = cot_rc($L['paypaycontacts_mail_remind'], array(
  'days' => 5,
 ));
 cot_mail($urr['user_email'], $L['paypaycontacts_mail_remind_title'], $rbody);
 
 $db->update($db_users,  array('user_paycontacts_sended' => 25), "user_id=".(int)$urr['user_id']);
}                                          

?>