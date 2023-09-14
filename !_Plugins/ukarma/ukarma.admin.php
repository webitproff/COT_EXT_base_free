<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

/**
 * ukarma plugin
 *
 * @package ukarma
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('ukarma', 'plug');

list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

$id = cot_import('id', 'G', 'INT');
$a = cot_import('a', 'G', 'ALP');

if ($a == 'delete'){
	
	cot_check_xg();
	
	if($ukarma = $db->query("SELECT * FROM $db_ukarma WHERE ukarma_id=".$id)->fetch()){
		$score = $db->query("SELECT SUM(ukarma_value) FROM $db_ukarma WHERE ukarma_userid=".$ukarma['ukarma_userid'])->fetchColumn();
		$score = $score - $ukarma['ukarma_value'];
		
		$db->update($db_users, array('user_ukarma' => $score), "user_id=".$ukarma['ukarma_userid']);
		$db->delete($db_ukarma, "ukarma_id=".$id);
	}
	cot_redirect(cot_url('admin', 'm=other&p=ukarma', '', true));
}

$t = new XTemplate(cot_tplfile('ukarma.admin', 'plug', true));

$where['all'] = "1";
$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_ukarma ".$where)->fetchColumn();
$sql = $db->query("SELECT * FROM $db_ukarma ".$where." ORDER BY ukarma_date DESC LIMIT $d, ".$cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', 'm=other&p=ukarma', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '');

$t->assign(array(
	'ADMIN_PAGE_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_PAGE_PAGNAV' => $pagenav['main'],
	'ADMIN_PAGE_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_PAGE_TOTALITEMS' => $totalitems,
));

while($ukarma = $sql->fetch()){
	$t->assign(cot_generate_usertags($ukarma['ukarma_userid'], 'UKARMA_ROW_TOUSER_'));
	$t->assign(cot_generate_usertags($ukarma['ukarma_ownerid'], 'UKARMA_ROW_FROMUSER_'));
	$t->assign(array(
		'UKARMA_ROW_DATE' => $ukarma['ukarma_date'],
		'UKARMA_ROW_AREA' => $ukarma['ukarma_area'],
		'UKARMA_ROW_CODE' => $ukarma['ukarma_code'],
		'UKARMA_ROW_VALUE' => $ukarma['ukarma_value'],
		'UKARMA_ROW_DELETE_URL' => cot_url('admin', 'm=other&p=ukarma&a=delete&id='.$ukarma['ukarma_id'].'&'.cot_xg(), '', true),
	));
	$t->parse('MAIN.UKARMA_ROW');
}


$t->parse('MAIN');
$adminmain = $t->text('MAIN');