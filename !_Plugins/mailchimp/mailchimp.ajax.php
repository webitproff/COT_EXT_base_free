<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('mailchimp', 'plug');

$a = cot_import('a', 'G', 'TXT');
$id = cot_import('id', 'G', 'TXT');

if(empty($a)) $a = cot_import('amp;a', 'G', 'TXT');
if(!$id) $id = cot_import('amp;id', 'G', 'TXT');

if($a == 'add')
{
  $name = cot_import('rsp_name', 'P', 'TXT');
  $email = cot_import('rsp_email', 'P', 'TXT');
  $phone = cot_import('rsp_phone', 'P', 'TXT');
  $check = cot_import('rsp_check', 'P', 'INT');

  $return = array('status' => 'success', 'msg' => (($check == 1) ? $L['mailchimp_form_send_withcomform'] : $L['mailchimp_form_send_default']));
  if(!empty($email))
  {
   if($check == 1)
   {
		$tmail = new XTemplate(cot_tplfile(array('mailchimp', 'mail'), 'plug'));
		$tmail->assign('CONFIRM_HREF', COT_ABSOLUTE_URL . cot_url('plug', 'r=mailchimp&a=confirm&data='.base64_encode(json_encode(array($id, $email, $name, $phone)))));
		$tmail->parse('MAIN');

		cot_mail($email, $L['mailchimp_mail_confirm_title'], $tmail->text('MAIN'), '', false, null, true);
   }
   elseif(!empty($id))
   {
     if(!$name) $name = '';
     if(!$phone) $phone = '';
     if(cot_mailchimp_subscribe($id, $email, 'subscribed', array('FNAME' => $name, 'PHONE' => $phone)) == 200) {

     }
   } else {
     $return = array('status' => 'error', 'msg' => 'Wrong params');
   }
  }
  else
  {
   $return = array('status' => 'error', 'msg' => $L['mailchimp_form_check_email']);
  }
  echo json_encode($return);
}
elseif($a == 'confirm')
{
  $data = cot_import('data', 'G', 'TXT');
  $data = (!empty($data)) ? json_decode(base64_decode($data), 1) : array();
  $status = 'error';

  require_once $cfg['system_dir'].'/header.php';

  if(!empty($data[0]) && !empty($data[1]))
  {
    if(!$data[2]) $data[2] = '';
    if(!$data[3]) $data[3] = '';

    if(cot_mailchimp_subscribe($data[0], $data[1], 'subscribed', array('FNAME' => $data[2], 'PHONE' => $data[3])) == 200) {

    }
    $status = 'success';
  }
  $t = new XTemplate(cot_tplfile(array('mailchimp', 'status.'.$status), 'plug'));
	$t->parse('MAIN');
  echo $t->text('MAIN');
  require_once $cfg['system_dir'].'/footer.php';
}
