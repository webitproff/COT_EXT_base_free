<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('sendpulse', 'plug');
require_once cot_langfile('sendpulse', 'plug');

$a = cot_import('a', 'G', 'TXT');
$id = cot_import('id', 'G', 'INT');

if(empty($a)) $a = cot_import('amp;a', 'G', 'TXT');
if(!$id) $id = cot_import('amp;id', 'G', 'INT');

if($a == 'del' && $id > 0 && ($usr['maingrp'] == 5 || $usr['maingrp'] == 6))
{
  $email = cot_import('email', 'G', 'TXT');
  if(!empty($email))
  {
    $SPApiProxy = new SendpulseApi( SENDPULSE_API_USER_ID, SENDPULSE_API_SECRET, SENDPULSE_TOKEN_STORAGE );
    $SPApiProxy->removeEmails($id, array($email));
  }
}
elseif($a == 'add' && $id > 0)
{
  $email = cot_import('rsp_email', 'P', 'TXT');
  $check = cot_import('rsp_check', 'P', 'INT');

  $return = array('status' => 'success', 'msg' => (($check == 1) ? $L['sendpulse_form_send_withcomform'] : $L['sendpulse_form_send_default']));
  if(!empty($email))
  {
   $newemail = array('email' => $email, 'variables' => array());
   $jj=0;
   foreach(explode('|', $cfg['plugin']['sendpulse']['apiform']) as $variable)
   {
    $variable = explode('&', $variable);
    if(!empty($variable[0])) $newemail['variables'][$variable[0]] = cot_import('rsp_'.$jj, 'P', 'TXT');
    $jj++;
   }

   if($check == 1)
   {
		$tmail = new XTemplate(cot_tplfile(array('sendpulse', 'mail.confirm'), 'plug'));
		$tmail->assign('CONFIRM_HREF', COT_ABSOLUTE_URL . cot_url('plug', 'r=sendpulse&a=confirm&data='.base64_encode(json_encode(array($id, $email, $newemail['variables'])))));
		$tmail->parse('MAIN');

		cot_mail($email, $L['sendpulse_mail_confirm_title'], $tmail->text('MAIN'), '', false, null, true);
   }
   else
   {
     $SPApiProxy = new SendpulseApi( SENDPULSE_API_USER_ID, SENDPULSE_API_SECRET, SENDPULSE_TOKEN_STORAGE );
     $SPApiProxy->addEmails($id, array($newemail));
   }
  }
  else
  {
   $return = array('status' => 'error', 'msg' => $L['sendpulse_form_check_email']);
  }
  echo json_encode($return);
}
elseif($a == 'confirm')
{
  $data = cot_import('data', 'G', 'TXT');
  $data = (!empty($data)) ? json_decode(base64_decode($data), 1) : array();
  $status = 'error';

  require_once $cfg['system_dir'].'/header.php';

  if($data[0] > 0 && !empty($data[1]))
  {
    $id = $data[0];
    $newemail = array('email' => $data[1], 'variables' => $data[2]);
    $SPApiProxy = new SendpulseApi( SENDPULSE_API_USER_ID, SENDPULSE_API_SECRET, SENDPULSE_TOKEN_STORAGE );
    $SPApiProxy->addEmails($id, array($newemail));
    $status = 'success';
  }
  $t = new XTemplate(cot_tplfile(array('sendpulse', 'status.'.$status), 'plug'));
	$t->parse('MAIN');
  echo $t->text('MAIN');
  require_once $cfg['system_dir'].'/footer.php';
}