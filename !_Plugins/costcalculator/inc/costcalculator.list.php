<?php defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'costcalculator', 'RWA');
cot_block($usr['auth_read']);

//пагінація
list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['costcalculator']['cc_rowsperpage']);

//сео
$out['subtitle'] = $L['info_name'];
$out['desc'] = $L['info_desc'];
$out['keywords'] = $L['cc_keywords'];

//шаблон
$mskin = cot_tplfile(array('costcalculator', 'list'), 'plug');
$t = new XTemplate($mskin);

$sqllist = $db->query("SELECT c.*, 
         				COUNT(cr.ccr_id) as cc_row_count,
        				COUNT(DISTINCT cu.ccu_user_id) as ur_specialists
    					FROM $db_cc_calcs AS c
    					INNER JOIN $db_cc_calcs_rows AS cr ON c.cc_id = cr.cc_id 
   						LEFT OUTER JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
						GROUP BY c.cc_id
						HAVING cc_row_count > 0
						ORDER BY c.cc_order ASC 
						LIMIT $d, " . $cfg['plugin']['costcalculator']['cc_rowsperpage'])->fetchAll();
//рядки
foreach ($sqllist as $row) {

	$t->assign(array(
		'CC_ROW_ID'  => $row['cc_id'],
		'CC_ROW_NAME'  => $row['cc_name'],
		'CC_ROW_DESC'  => $row['cc_desc'],
		'CC_ROW_USERS' => cot_declension($row['ur_specialists'],$Ls['cc_specialiss']),
		'CC_ROW_NUMROW' => $row['cc_row_count']
	));
	$t->parse('MAIN.CC_ROW');
}

//якщо користувач гість або не має доступних для нього калькуляторів то CC_ALLOW_FILL = 0
if($usr['id'] < 1){
	$allowfill = 0;
}else{
	$sqlallow = $db->query("SELECT COUNT(*) as caclforfill FROM $db_cc_calcs WHERE cc_groups LIKE '%".$usr['maingrp']."%'")->fetch(); // LIKE '%".$usr['maingrp']."%' TODO FIX IT 
	$allowfill = $sqlallow['caclforfill'];
}

$t->assign(array(
	"CC_ALLOW_FILL" => $allowfill
));


//пагінація
$totalitems = $db->query("SELECT COUNT(*) FROM $db_cc_calcs")->fetchColumn();
$list_url_path = array ('e' => 'costcalculator');
$pagenav = cot_pagenav('costcalculator', $list_url_path, $d, $totalitems, $cfg['plugin']['costcalculator']['cc_rowsperpage']);

$t->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems
));

//повідомлення
cot_display_messages($t);