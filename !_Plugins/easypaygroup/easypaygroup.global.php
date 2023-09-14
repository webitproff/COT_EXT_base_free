<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('easypaygroup', 'plug');
require_once cot_incfile('users', 'module');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату услуги для юзеров. Если есть то включаем услугу.
$easypaygroup_cfg = cot_cfg_easypaygroup();
foreach($easypaygroup_cfg as $code => $opt)
{
	if ($easypaygroups = cot_payments_getallpays('easypaygroup.'.$code, 'paid'))
	{
		foreach ($easypaygroups as $pay)
		{
			if ($pay['pay_userid'] > 0 && cot_payments_updatestatus($pay['pay_id'], 'done'))
			{
				$owner = $db->query("SELECT * FROM $db_users WHERE user_id=".$pay['pay_userid'])->fetch();

        $timepaygroup = ($owner['user_maingrp'] == $code && $owner['user_paygroup'] > $sys['now']) ? $owner['user_paygroup'] : $sys['now'];
        $timepaygroup_start = ($owner['user_maingrp'] == $code && $owner['user_paygroup_start'] > $sys['now']) ? $owner['user_paygroup_start'] : $sys['now'];
        $timepaygroup += (86400*$opt['time']);

        $db->update($db_users, array('user_maingrp' => $code, 'user_paygroup' => $timepaygroup, 'user_paygroup_start' => $timepaygroup_start), 'user_id='.$owner['user_id']);
        $db->update($db_groups_users, array('gru_groupid' => $code), 'gru_userid='.$owner['user_id']);

				// отправляем админу детали операции на email
				$subject = $L['easypaygroup_email_paid_admin_subject'];
				$body = sprintf($L['easypaygroup_email_paid_admin_body'], $owner['user_name'], $pay['pay_desc'], $pay['pay_summ'].' '.$cfg['payments']['valuta'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
				cot_mail($cfg['adminemail'], $subject, $body);

				// отправляем пользователю детали операции на email
				$subject = $L['easypaygroup_email_paid_customer_subject'];
				$body = sprintf($L['easypaygroup_email_paid_customer_body'], $owner['user_name'], $pay['pay_desc'], $pay['pay_summ'].' '.$cfg['payments']['valuta'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
				cot_mail($owner['user_email'], $subject, $body);

				/* === Hook === */
				foreach (cot_getextplugins('easypaygroup.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

				/* === Hook === */
				foreach (cot_getextplugins('easypaygroup.'.$code.'.done') as $pl)
				{
					include $pl;
				}
				/* ===== */
			}
		}
	}
}

// Проверяем платежки на оплату услуги для гостей. Если есть то включаем услугу.
foreach($easypaygroup_cfg as $code => $opt)
{
	if ($easypaygroups = cot_payments_getallpays('easypaygroupguest.'.$code, 'paid'))
	{
		foreach ($easypaygroups as $pay)
		{
			if (cot_payments_updatestatus($pay['pay_id'], 'done'))
			{
        $paygroupinfo = $db->query("SELECT * FROM $db_easypaygroup WHERE item_email='".$pay['pay_email']."' ORDER BY item_id DESC LIMIT 1")->fetch();
        $pass = cot_get_easypaygroup_pass(6, false);

      	$ruser['user_email'] = $paygroupinfo['item_email'];
        $ruser['user_email'] = mb_strtolower($ruser['user_email']);

      	$ruser['user_name'] = explode('@', $ruser['user_email']);
        $ruser['user_name'] = (!empty($ruser['user_name'][0])) ? $ruser['user_name'][0] : 'user';

      	$ruser['user_country'] = 'ru';

      	while ((bool)$db->query("SELECT user_id FROM $db_users WHERE user_name = ? LIMIT 1", array($ruser['user_name']))->fetch())
        {
         $ruser['user_name'] = $ruser['user_name'].cot_get_easypaygroup_pass(1, true);
        }

      	$ruser['user_password'] = $pass;
      	$userid = cot_add_user($ruser, null, null, null, $code, false);

        if($userid > 0)
        {
  				$owner = $db->query("SELECT * FROM $db_users WHERE user_id=".$userid)->fetch();

          $timepaygroup_start = ($owner['user_maingrp'] == $code && $owner['user_paygroup_start'] > $sys['now']) ? $owner['user_paygroup_start'] : $sys['now'];
          $timepaygroup = ($owner['user_maingrp'] == $code && $owner['user_paygroup'] > $sys['now']) ? $owner['user_paygroup'] : $sys['now'];
          $timepaygroup += (86400*$opt['time']);

          $db->update($db_users, array('user_maingrp' => $code, 'user_paygroup' => $timepaygroup, 'user_paygroup_start' => $timepaygroup_start), 'user_id='.$owner['user_id']);

          $db->update($db_payments, array('pay_userid' => $owner['user_id']), 'pay_id='.$pay['pay_id']);

  				// отправляем админу детали операции на email
  				$subject = $L['easypaygroup_email_paid_admin_subject'];
  				$body = sprintf($L['easypaygroup_email_paid_admin_body'], $owner['user_name'], $pay['pay_desc'], $pay['pay_summ'].' '.$cfg['payments']['valuta'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
  				cot_mail($cfg['adminemail'], $subject, $body);

  				// отправляем пользователю детали операции на email
  				$subject = $L['easypaygroup_email_paid_guest_subject'];
  				$body = sprintf($L['easypaygroup_email_paid_guest_body'], $owner['user_name'], $pay['pay_desc'], $pay['pay_summ'].' '.$cfg['payments']['valuta'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']), $owner['user_name'], $pass);
  				cot_mail($owner['user_email'], $subject, $body);

  				/* === Hook === */
  				foreach (cot_getextplugins('easypaygroupguest.done') as $pl)
  				{
  					include $pl;
  				}
  				/* ===== */

  				/* === Hook === */
  				foreach (cot_getextplugins('easypaygroupguest.'.$code.'.done') as $pl)
  				{
  					include $pl;
  				}
  				/* ===== */
        }
        elseif(!empty($paygroupinfo['item_email']))
        {
  				// отправляем админу детали об ошибке на email
  				$subject = 'Уведомление Easy Pay Group';
  				$body = 'Не удалось зарегистрировать пользователя который оплатил Easy Pay Group, емаил: '.$ruser['user_email'];
  				cot_mail($cfg['adminemail'], $subject, $body);
        }
			}
		}
	}
}

//Проверяем окончание времени нахождения в группе
$expiredpaygroup = $db->query("SELECT * FROM $db_users WHERE user_paygroup>0 AND user_paygroup<".$sys['now'])->fetchAll();
foreach($expiredpaygroup as $payurr)
{
  $db->update($db_users, array('user_maingrp' => $cfg['plugin']['easypaygroup']['defaultgroup'], 'user_paygroup' => 0, 'user_paygroup_start' => 0), 'user_id='.$payurr['user_id']);
  $db->update($db_groups_users, array('gru_groupid' => $cfg['plugin']['easypaygroup']['defaultgroup']), 'gru_userid='.$payurr['user_id']);
}

if($usr['id'] == 0 && $cfg['plugin']['easypaygroup']['autologin'] == 0)
{
  $payinfo = cot_import('easypaygroup', 'C', 'TXT');
  if(!empty($payinfo))
  {
   $payinfo = explode('_', $payinfo);
   if($payinfo[0] > 0 && $payinfo[1] > 0 && $payinfo[2] > 0)
   {
     $payinfo = $db->query("SELECT u.* FROM $db_easypaygroup as e
         LEFT JOIN $db_users as u ON e.item_email=u.user_email
         LEFT JOIN $db_payments as p ON p.pay_userid=u.user_id
         WHERE e.item_id=".(int)$payinfo[0]." AND e.item_date=".(int)$payinfo[2]." AND e.item_code=".$payinfo[1]." AND p.pay_status='done' AND p.pay_area='easypaygroupguest.".$payinfo[1]."' LIMIT 1")->fetch();
     if($payinfo['user_id'] > 0)
     {
  		$token = cot_unique(16);

  		$sid = hash_hmac('sha256', $payinfo['user_password'] . $row['user_sidtime'], $cfg['secret_key']);

  		if (empty($row['user_sid']) || $row['user_sid'] != $sid
  			|| $row['user_sidtime'] + $cfg['cookielifetime'] < $sys['now'])
  		{
  			$sid = hash_hmac('sha256', $payinfo['user_password'] . $sys['now'], $cfg['secret_key']);
  			$update_sid = ", user_sid = " . $db->quote($sid) . ", user_sidtime = " . $sys['now'];
  		}
  		else
  		{
  			$update_sid = '';
  		}

  		$db->query("UPDATE $db_users SET user_lastip='{$usr['ip']}', user_lastlog = {$sys['now']}, user_logcount = user_logcount + 1, user_token = '$token' $update_sid WHERE user_id={$payinfo['user_id']}");

  		$sid = hash_hmac('sha1', $sid, $cfg['secret_key']);

  		$u = base64_encode($payinfo['user_id'].':'.$sid);

  		$_SESSION[$sys['site_id']] = $u;

  		cot_uriredir_apply($cfg['redirbkonlogin']);
  		cot_uriredir_redirect(cot_url('index'));
     }
   }
   setcookie("easypaygroup", '', time()-1382400);
  }
}

?>