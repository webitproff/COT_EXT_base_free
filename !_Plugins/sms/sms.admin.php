<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sms','plug');
$cfg['maxrowsperpage'] = 20;
list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

$t = new XTemplate(cot_tplfile('sms', 'plug', 'admin'));

$totallines = $db->query("SELECT COUNT(*) FROM $db_sms_logs AS l
	LEFT JOIN $db_users AS u ON u.user_id=l.log_userid
	WHERE 1")->fetchColumn();

$sql = $db->query("SELECT * FROM $db_sms_logs AS l
	LEFT JOIN $db_users AS u ON u.user_id=l.log_userid
	WHERE 1 ORDER by log_date DESC LIMIT $d, " . $cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', 'm=other&p=sms', $d, $totallines, $cfg['maxrowsperpage']);

$t->assign(array(
	'PAGENAV_PAGES' => $pagenav['main'],
	'PAGENAV_PREV' => $pagenav['prev'],
	'PAGENAV_NEXT' => $pagenav['next'],
	'TOTALLINES' => $totallines,
));

while ($log = $sql->fetch())
{
	$jj++;

	$t->assign(cot_generate_usertags($log, 'LOG_ROW_OWNER_'));

	$t->assign(array(
		'LOG_ROW_NUM' => $jj,
		'LOG_ROW_DATE' => $log['log_date'],
		'LOG_ROW_PHONE' => $log['log_phone'],
		'LOG_ROW_TEXT' => $log['log_text'],
		'LOG_ROW_API' => $log['log_api'],
	));

	$t->parse("MAIN.LOG_ROW");
}

$t->parse('MAIN');
$plugin_body .= $t->text('MAIN');