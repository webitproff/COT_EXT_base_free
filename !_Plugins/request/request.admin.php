<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('request', 'plug');

// if (!$db->fieldExists($db_requests, "request_email"))
// {
// 	$db->query("ALTER TABLE `$db_requests` ADD COLUMN `request_email` varchar(255) collate utf8_unicode_ci NOT NULL default ''");
// }

$t = new XTemplate(cot_tplfile('request.admin', 'plug', true));

if($n == 'edit')
{
	$sql = $db->query("SELECT * FROM $db_requests WHERE request_id=".$id);
	cot_die($sql->rowCount() == 0);
	$rreq = $sql->fetch();

	if($a == 'update'){
		$rreq['request_title'] = cot_import('rtitle', 'P', 'TXT');
		$rreq['request_deadline'] = cot_import('rdeadline', 'P', 'TXT');
		$rreq['request_name'] = cot_import('rname', 'P', 'TXT');
		$rreq['request_phone'] = cot_import('rphone', 'P', 'TXT');
		$rreq['request_email'] = cot_import('remail', 'P', 'TXT');

		$db->update($db_requests, $rreq, 'request_id='.$id);

		cot_redirect(cot_url('admin', 'm=other&p=request', '', true));
	}

	$t->assign(array(
		'FORM_SEND' => cot_url('admin', 'm=other&p=request&n=edit&a=update&id='.$id),
		'FORM_TITLE' => cot_inputbox('text', 'rtitle', $rreq['request_title'], 'size="56"'),
		'FORM_DEADLINE' => cot_inputbox('text', 'rdeadline', $rreq['request_deadline'], 'size="56" class="datepicker"'),
		'FORM_NAME' => cot_inputbox('text', 'rname', $rreq['request_name'], 'size="56"'),
		'FORM_PHONE' => cot_inputbox('text', 'rphone', $rreq['request_phone'], 'size="56"'),
		'FORM_EMAIL' => cot_inputbox('text', 'remail', $rreq['request_email'], 'size="56"'),
	));

	$t->parse('MAIN.EDIT');
}
elseif($n == 'delete')
{
	cot_check_xg();

	$db->delete($db_requests, 'request_id='.$id);

	cot_redirect(cot_url('admin', 'm=other&p=request', '', true));
}
else
{
	$reqs = $db->query("SELECT * FROM $db_requests AS r
		LEFT JOIN $db_projects AS p ON p.item_requestid=r.request_id
		WHERE 1 ORDER BY request_date DESC")->fetchAll();
	foreach ($reqs as $req)
	{
		$t->assign(cot_generate_usertags($req['request_userid'], 'REQ_ROW_USER'));
		$t->assign(array(
			'REQ_ROW_ID' => $req['request_id'],
			'REQ_ROW_DATE' => $req['request_date'],
			'REQ_ROW_TITLE' => $req['request_title'],
			'REQ_ROW_DEADLINE' => $req['request_deadline'],
			'REQ_ROW_NAME' => $req['request_name'],
			'REQ_ROW_PHONE' => $req['request_phone'],
			'REQ_ROW_EMAIL' => $req['request_email'],
			'REQ_ROW_PROJECTID' => $req['item_id'],
			'REQ_ROW_STATUS' => $req['request_status'],
			'REQ_ROW_OFFER_URL' => ($req['request_status'] == 'offer' || $req['request_status'] == 'paid') ? cot_url('index', 'r=request&id='.$req['request_id'].'&hash='.md5($req['request_id'].$req['item_id'])) : '',
			'REQ_ROW_DELETE_URL' => cot_url('admin', 'm=other&p=request&n=delete&id='.$req['request_id'].'&'.cot_xg()),
		));
		$t->parse('MAIN.LIST.REQ_ROW');
	}

	$t->parse('MAIN.LIST');
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');