<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_langfile('request', 'plug');

$id = cot_import('id', 'G', 'INT');
$pid = cot_import('pid', 'G', 'INT');

if(empty($id) && empty($pid))
{

	$out['subtitle'] = 'Создание заказа';

	if($a == 'send')
	{
		$rtitle = cot_import('rtitle', 'P', 'TXT');
		$rdeadline = cot_import('rdeadline', 'P', 'TXT');
		$rname = cot_import('rname', 'P', 'TXT');
		$rphone = cot_import('rphone', 'P', 'TXT');
		$remail = cot_import('remail', 'P', 'TXT');

		cot_check(empty($rtitle), 'Укажите объект съемки', 'rtitle');
		cot_check(empty($rname), 'Укажите ваше имя', 'rname');
		cot_check(empty($rphone), 'Укажите номер телефона', 'rphone');
		cot_check(empty($remail), 'Укажите вашу почту', 'remail');

		if(!cot_error_found())
		{
			$rreq['request_title'] = $rtitle;
			$rreq['request_userid'] = $usr['id'];
			$rreq['request_date'] = $sys['now'];
			$rreq['request_deadline'] = $rdeadline;
			$rreq['request_name'] = $rname;
			$rreq['request_phone'] = $rphone;
			$rreq['request_email'] = $remail;
			$rreq['request_status'] = 'new';

			if($db->insert($db_requests, $rreq))
			{
				$requestid = $db->lastInsertId();

				$subject = $L['request_email_subject'];
				$body = cot_rc($L['request_email_body'], array(
					'rtitle' => $rtitle,
					'rdeadline' => $rdeadline,
					'rname' => $rname,
					'rphone' => $rphone,
					'remail' => $remail,
					));

				$email = ($cfg['plugin']['request']['email']) ? $cfg['plugin']['request']['email'] : $cfg['adminemail'];

				cot_mail($email, $subject, $body);

				define('CRM_HOST', 'pilothub.bitrix24.ru'); // your CRM domain name
				define('CRM_PORT', '443'); // CRM server port
				define('CRM_PATH', '/crm/configs/import/lead.php'); // CRM server REST service path

				$postData = array(
					'TITLE' => $rtitle,
					'NAME' => $rname,
					'PHONE_WORK' => $rphone,
					'EMAIL_WORK' => $remail,
					'COMMENTS' => 'Срок: '.$rdeadline,
				);

				$postData['LOGIN'] = $cfg['plugin']['request']['b24login'];
			 	$postData['PASSWORD'] = $cfg['plugin']['request']['b24pass'];

				// open socket to CRM
				$fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
				if ($fp)
				{
					// prepare POST data
					$strPostData = '';
					foreach ($postData as $key => $value)
						$strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);

					//echo $strPostData;
					// prepare POST headers
					$str = "POST ".CRM_PATH." HTTP/1.0\r\n";
					$str .= "Host: ".CRM_HOST."\r\n";
					$str .= "Content-Type: application/x-www-form-urlencoded\r\n";
					$str .= "Content-Length: ".strlen($strPostData)."\r\n";
					$str .= "Connection: close\r\n\r\n";

					$str .= $strPostData;

					// send POST to CRM
					fwrite($fp, $str);

					// get CRM headers
					$result = '';
					while (!feof($fp))
					{
						$result .= fgets($fp, 128);
					}
					fclose($fp);

					// cut response headers
					$response = explode("\r\n\r\n", $result);

					$output = '<pre>'.print_r($response[1], 1).'</pre>';

					cot_log($output, 'def');
				}
			}
			cot_redirect(cot_url('request', 'm=sent', '', true));
		}
		cot_redirect(cot_url('request', '', '', true));
	}

	$t->assign(array(
		'FORM_SEND' => cot_url('request', 'a=send'),
		'FORM_TITLE' => cot_inputbox('text', 'rtitle', $rtitle, 'size="56"'),
		'FORM_DEADLINE' => cot_inputbox('text', 'rdeadline', $rdeadline, 'size="56"'),
		'FORM_NAME' => cot_inputbox('text', 'rname', $rname, 'size="56"'),
		'FORM_PHONE' => cot_inputbox('text', 'rphone', $rphone, 'size="56"'),
		'FORM_EMAIL' => cot_inputbox('text', 'remail', $remail, 'size="56"'),
	));

	cot_display_messages($t);
}
else
{
	if(!empty($id))
	{
		if($a == 'newoffer')
		{
			$sql = $db->query("SELECT * FROM $db_requests AS r 
				LEFT JOIN $db_projects AS p ON r.request_id= p.item_requestid 
				WHERE request_id=".$id);
			cot_die($sql->rowCount() == 0);
			$request = $sql->fetch();

			$rname = cot_import('rname', 'P', 'TXT');
			$rpilots = cot_import('rpilots', 'P', 'ARR');
			$rpilotscomments = cot_import('rpilotscomments', 'P', 'ARR');

			$rreq['request_name'] = $rname;
			$rreq['request_pilots'] = implode(',', $rpilots);
			$rreq['request_status'] = 'offer';

			if(!empty($rreq['request_name']) && !empty($rreq['request_pilots'])){
				$db->update($db_requests, $rreq, 'request_id='.$id);

				$db->delete($db_requests_pilots, 'pilot_rid='.$id);
				foreach ($rpilots as $pilotid) {
					$rcomment['pilot_rid'] = $id;
					$rcomment['pilot_id'] = $pilotid;
					$rcomment['pilot_comment'] = $rpilotscomments[$pilotid];

					$db->insert($db_requests_pilots, $rcomment);
				}

				$hash = md5($id.$request['item_id']);

				cot_redirect(cot_url('index', 'r=request&id='.$id.'&hash='.$hash, '', true));
			}else{
				cot_redirect(cot_url('projects', 'id='.$request['request_pid'], '', true));
			}
		}

		cot_redirect(cot_url('request', '', '', true));
	}
	else
	{
		if($a == 'newoffer')
		{
			$sql = $db->query("SELECT * FROM $db_projects WHERE item_id=".$pid);
			cot_die($sql->rowCount() == 0);
			$item = $sql->fetch();

			$rname = cot_import('rname', 'P', 'TXT');
			//$remail = cot_import('remail', 'P', 'TXT');
			$rpilots = cot_import('rpilots', 'P', 'ARR');
			$rpilotscomments = cot_import('rpilotscomments', 'P', 'ARR');

			$rreq['request_title'] = $item['item_title'];
			$rreq['request_userid'] = 0;
			$rreq['request_date'] = $sys['now'];
			$rreq['request_deadline'] = ($item['item_deadline'] > 0) ? $item['item_deadline'] : '';
			$rreq['request_name'] = $rname;
			//$rreq['request_email'] = $remail;
			$rreq['request_pilots'] = implode(',', $rpilots);
			$rreq['request_status'] = 'offer';

			if($db->insert($db_requests, $rreq))
			{
				$requestid = $db->lastInsertId();


				$db->delete($db_requests_pilots, 'pilot_rid='.$requestid);
				foreach ($rpilots as $pilotid) {
					$rcomment['pilot_rid'] = $requestid;
					$rcomment['pilot_id'] = $pilotid;
					$rcomment['pilot_comment'] = $rpilotscomments[$pilotid];

					$db->insert($db_requests_pilots, $rcomment);
				}

				$db->update($db_projects, array('item_requestid' => $requestid), "item_id=".$pid);

				$hash = md5($requestid.$pid);

				cot_redirect(cot_url('index', 'r=request&id='.$requestid.'&hash='.$hash, '', true));
			}
		}

		cot_redirect(cot_url('projects', 'id='.$pid, '', true));
	}

}