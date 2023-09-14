<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('mailchimp', 'plug');

function cot_mailchimp_form($listid = '', $check = 0, $tpl = '')
{
  global $cfg, $usr, $L;

  $check = ($check > 0) ? 1 : 0;
  if(!empty($listid))
  {
   $tt = new XTemplate(cot_tplfile(array('mailchimp', 'form', (empty($tpl) ? 'default' : ($tpl == 'popup' ? 'popup' : 'redir'))), 'plug'));

   $tt->assign(array(
    'FORM_CHECK' => $check,
    'FORM_ID' => rand(0, 99999),
    'BOOK_ID' => $listid,
    'FORM_POPUP' => (($tpl == 'popup') ? 1 : 0),
    'FORM_REDIR' => ((!empty($tpl) && $tpl != 'popup') ? $tpl : ''),
   ));

   $tt->parse('MAIN');
   return $tt->text('MAIN');
  }
  else { return ''; }
}

function cot_mailchimp_subscribe($list_id, $email, $status, $merge_fields = array('FNAME' => '','LNAME' => '') )
{
    global $cfg;
    $api_key = $cfg['plugin']['mailchimp']['apikey'];
    $data = array(
      //  'apikey'        => $api_key,
        'email_address' => strtolower($email),
        'status'        => $status,
        'merge_fields'  => $merge_fields
    );
    $mch_api = curl_init();
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/'); //. md5(strtolower($data['email_address'])));
    curl_setopt($mch_api, CURLOPT_USERPWD, 'user:' . $api_key);
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) );
    $result = curl_exec($mch_api);
    $result = curl_getinfo($mch_api, CURLINFO_HTTP_CODE);
    curl_close($mch_api);
    return $result;
}
