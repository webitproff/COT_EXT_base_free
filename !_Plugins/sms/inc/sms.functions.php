<?php

defined('COT_CODE') or die('Wrong URL');

cot::$db->registerTable('sms_logs');

function sms_generatecode($area = '', $length = 6, $use_cookie = true, $uniq = ''){
	global $sys;
	
	if (!$uniq) $uniq = cot_unique($length);
	$uniq = str_replace(str_split('ABCDEF'), str_split('012345'), strtoupper($uniq));
	$uhash = sha1($uniq.$sys['xk']);
	if ($use_cookie) {
		setcookie($area.'_schash', $uhash, time()+24*60*60, '/');
	}
	
	return array($uniq, $uhash);
}

function sms_checkcode($area = '', $code, $hash = ''){
	global $sys;
	
	if (!$hash) {
		$hash = cot_import($area.'_schash', 'C', 'ALP');
	}
	$valid = ($hash == sha1($code.$sys['xk']));
	
	return $valid;
}

function sms_send($params, $sms_api = ''){
	global $cfg, $sys, $usr, $smsru, $smsaero, $db, $db_sms_logs;
	
	//$params['to'] = ($params['to'][0] != 8) ? '8'.$params['to'] : $params['to'];
	$phone = $params['to'];
	if($sms_api == ''){
		$sms_api = $cfg['plugin']['sms']['api'];
	}
	
	$rlog['log_date'] = $sys['now'];
	$rlog['log_api'] = $sms_api;
	$rlog['log_userid'] = $usr['id'];
	$rlog['log_phone'] = $phone;
	$rlog['log_text'] = $params['text'];
	$db->insert($db_sms_logs, $rlog);

	switch($sms_api){
		case 'smsru':
			require_once cot_incfile('smsru','plug');
			$params['to'] = smsru_get_ownnumber($params['to']);
			$id = $smsru->send($params);
			break;
		case 'smsaero':
			require_once cot_incfile('smsaero','plug');
			$id = $smsaero->send($params['to'], $params['text']);
			break;
		case 'testapi':
			$id = '123456';
			break;
	}
	
	return $id;
}