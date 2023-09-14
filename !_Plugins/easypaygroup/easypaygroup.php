<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_incfile('easypaygroup', 'plug');

$code = cot_import('code', 'G', 'ALP');

$easypaygroup_cfg = cot_cfg_easypaygroup();

if (empty($easypaygroup_cfg[$code]) && $a != 'login')
{
	cot_block();
}

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'easypaygroup');
cot_block($auth_read);

if ($a == 'buy')
{
	$email = cot_import('remail', 'P','TXT', 100, TRUE);

	if (!cot_check_email($email) && $usr['id'] == 0)	cot_error('aut_emailtooshort', 'remail');

	if (!cot_error_found())
	{
		$options['desc'] = ($usr['id'] == 0) ? $easypaygroup_cfg[$code]['name'].' ('.$email.')' : $easypaygroup_cfg[$code]['name'];

    if($usr['id'] == 0)
    {
  	 if ($db->fieldExists($db_payments, "pay_redirect")){
      if($cfg['plugin']['easypaygroup']['autologin'] == 0)
      {
  		 $options['redirect'] = $cfg['mainurl'].'/'.cot_url('plug', 'e=easypaygroup&a=login&m=check', '', true);
      }
      else
      {
       $options['redirect'] = $cfg['mainurl'].'/'.cot_url('login', '', '', true);
      }
     }
     $options['email'] = (!empty($email)) ? $email : '';
     $db->insert($db_easypaygroup, array('item_email' => $email, 'item_code' => $code, 'item_date' => $sys['now']));
     setcookie("easypaygroup", $db->lastInsertId().'_'.$code.'_'.$sys['now'], time()+1382400);
		 cot_payments_create_order('easypaygroupguest.'.$code, $easypaygroup_cfg[$code]['cost'], $options);
    }
    else
    {
  	 if ($db->fieldExists($db_payments, "pay_redirect")){
  		 $options['redirect'] = $cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
  	 }
     cot_payments_create_order('easypaygroup.'.$code, $easypaygroup_cfg[$code]['cost'], $options);
    }
  }
}
elseif ($a == 'login' && $cfg['plugin']['easypaygroup']['autologin'] == 0)
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
  else { cot_block(); }
}
elseif(empty($easypaygroup_cfg[$code]))
{
  cot_block();
}
else
{
 $t = new XTemplate(cot_tplfile(array('easypaygroup', $code), 'plug'));

 cot_display_messages($t);

 $alert = '';
 if($usr['profile']['user_paygroup'] > $sys['now']) {
  if($usr['profile']['user_maingrp'] == $code) {
   $alert = sprintf($L['easypaygroup_alert_ingroup'], cot_declension(round(($usr['profile']['user_paygroup']-$sys['now'])/86400), 'день,дня,дней'), $cot_groups[$usr['profile']['user_maingrp']]['name']);
  }
  else
  {
   $alert = sprintf($L['easypaygroup_alert_newgroup'], $cot_groups[$usr['profile']['user_maingrp']]['name']);
  }
  $alert .= '<br>';
 }

 $t->assign(array(
	'EASYPAY_FORM_ACTION' => cot_url('plug', 'e=easypaygroup&a=buy&code='.$code),
  'EASYPAY_FORM_ALERT' => $alert,
	'EASYPAY_FORM_COST' => $easypaygroup_cfg[$code]['cost'],
	'EASYPAY_FORM_NAME' => $easypaygroup_cfg[$code]['name'],
  'EASYPAY_FORM_TIME' => cot_declension($easypaygroup_cfg[$code]['time'], 'день,дня,дней'),
	'EASYPAY_FORM_EMAIL' => cot_inputbox('text', 'remail', ''),
 ));
}
?>