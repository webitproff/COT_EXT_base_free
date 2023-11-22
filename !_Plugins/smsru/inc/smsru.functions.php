<?php
/**
 * SMS.ru plugin API
 * @package Plugins/smsru
 * @author Andrey Matsovkin
 * @copyright Copyright (c) 2011-2014
 * @license Distributed under BSD license.
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_langfile('smsru', 'plug');

require_once $cfg['plugins_dir'].'/smsru/lib/smsru.php';

$smsru_cfg = $cfg['plugin']['smsru'];
$init_param = array(
	'api_id' => $smsru_cfg['api_id'],
	'auth_type' => $smsru_cfg['authtype'],
	'login' => $smsru_cfg['login'],
	'pass' => $smsru_cfg['password'],
	'sender_name' => $smsru_cfg['sendername'],
	'test_mode' => $smsru_cfg['testmode'],
	'lang_str' => $L['sms_state_msg'],
    'partner_id' => 57425,
	'debug' => true
);

global $smsru;
$smsru = new SMSRU($init_param);

/**
 * Get owner number (use login as number when specified or check allowed senders list)
 * @param string $number test
 * @return string
 */
function smsru_get_ownnumber($number){
	global $cfg, $smsru;
	
	$sms_cfg = $cfg['plugin']['smsru'];
	if (!$number) {
		if ($sms_cfg['login']) {
			$number = $sms_cfg['login'];
		}else {
			$senders = $smsru->my_senders();
			if (is_array($senders)) {
				$number = $senders[0];
			}
		}
	}
	
	return $number;
}

function smsru_check_auth(){
	global $cfg, $smsru, $L;
	
	$sms_cfg = $cfg['plugin']['smsru'];
	if ( $sms_cfg['login'] && $sms_cfg['password'] ) {
		$auth = $smsru->auth_check();
		if ($auth) {
			$result .= $L['sms_loginpass_ok'];
		} else {
			$result .= $L['sms_loginpass_error'];
		}
	} else {
		$result .= $L['sms_no_credentials'];
	}
	
	if ($sms_cfg['api_id']) {
		$auth = $smsru->auth_check(0);
		if ($auth ) {
			$result .= '<br />'.$L['sms_apikey_valid'];
		} else {
			$result .= '<br />'.$L['sms_apikey_invalid'];
		}
	}
	
	return $result;
}


function smsru_sendernames(){
	global $smsru;
	
	$senders = $smsru->my_senders();
	if (is_array($senders)) return $senders;
	
	return array('---');
}