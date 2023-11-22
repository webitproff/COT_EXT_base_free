<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');
define('SMS_AJAX',TRUE);
$plug_name = 'sms';

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'sms');
cot_block($usr['auth_read']);

header("Content-type: text/html; charset=utf-8");
if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	
	require_once cot_incfile('sms', 'plug');
	
	switch ($a) {
		case 'getcode':
			$timenow = cot_import('timenow', 'G', 'INT');
			$area = cot_import('area', 'G', 'ALP');
			$to = cot_import('phone', 'G', 'TXT');
            $to = ($to[0] != '+') ? '+'.$to : $to;

			$nextattempttime = cot_import($area.'_nextattempttime', 'C', 'INT');
			$attemptslockedtime = cot_import($area.'_attemptslockedtime', 'C', 'INT');
			$attempts = cot_import($area.'_attempts', 'C', 'INT');

            $phonehash = md5($to.$sys['site_id']);
			$lastphone = cot_import($area.'_lastphone', 'C', 'TXT');
			
			if($attemptslockedtime != 0 && $attemptslockedtime < $sys['now']){
				setcookie($area.'_attemptslockedtime', 0);
				setcookie($area.'_attempts', 0);
			}
			
			if(!empty($to)){
				$user_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_mobile = ? LIMIT 1", array($to))->fetch();
				if(!$user_exists){
					// Если не превышено количество попыток
					if($attempts < $cfg['plugin']['sms']['attemptslimit']){
					    if($nextattempttime < $sys['now']) {
                            // Номер не совпадает с предыдущим
    //						if($phonehash != $lastphone){
                                setcookie($area . '_nextattempttime', 0, time() + 24 * 60 * 60, '/');
                                $code = sms_generatecode($area);
                                $sms_param = array(
                                    'to' => $to,
                                    'text' => 'Код подтверждения: ' . $code[0] . '.'
                                );
                                $id = sms_send($sms_param);
                                if ($id) {
                                    $attempts++;

                                    setcookie($area . '_lastphone', md5($to . $sys['site_id']), time() + 24 * 60 * 60, '/');
                                    setcookie($area . '_attempts', $attempts, time() + 24 * 60 * 60, '/');
                                    setcookie($area . '_nextattempttime', $timenow + $cfg['plugin']['sms']['attemptstimeout'], time() + 24 * 60 * 60, '/');

                                    $status = 'success';
                                } else {
                                    $status = 'smsnotsended';
                                }
                                // Номер совпадает с предыдущим, то вывод поля ввода кода без повторной отправки смс
    //						}else{
    //							$status = 'showlastcode';
    //						}
                        }else{
                            $status = 'timernotout';
                        }
					// Если превышено количество попыток
					}else{
						// и введен последний номер
//						if($phonehash == $lastphone){
//							$status = 'showlastcode';
//						// иначе вывод сообщения что попытки исчерпаны
//						}else{
							setcookie($area.'_attemptslockedtime', time()+24*60*60, time()+24*60*60, '/');
							$status = 'attemptslocked';
//						}
					}
				} else {
					$status = 'userexists';
				}	
			} else {
				$status = 'phoneempty';
			}
			$data['attempts'] = $attempts;
		break;
		
		case 'checkcode':
			$area = cot_import('area', 'G', 'ALP');
			$code = cot_import('code', 'G', 'ALP');
			$schash = cot_import($area.'_schash', 'C', 'TXT');
			if(!empty($schash)) {
				if(sms_checkcode($area, $code, $schash)) {
					$status = 'success';
				} else {
					$status = 'wrongcode';
				}
			} else {
				$status = 'codeexpired';
			}

		break;
	}
	
	echo json_encode(array(
		'status' => $status,
		'info' => $data
	));
	
} else {
    echo 'NaAQ (not an ajax query)';
}