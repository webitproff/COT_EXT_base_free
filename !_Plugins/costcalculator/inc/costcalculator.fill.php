<?php defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');

$patharray[] = array(cot_url('costcalculator'), $L['costcalc_title']);

if(isset($id) || !empty($id)){ //заповнення калькулятора	

	if ($a == 'delete') { // видалення даних про ціни
		$deleted = $db->delete($db_cc_calcs_users_cost, "ccu_user_id=".$usr['id']." AND ccr_id IN (SELECT ccr_id FROM {$db_cc_calcs_rows} WHERE cc_id=".$id.")");
		if ($deleted == false) {			
			cot_message($L['cc_err_clean_calc'], 'error');
		}else{
			cot_log('Clean calc #'.$id.' by user id'.$usr["id"], 'adm');
			cot_message($L['cc_succ_clean_calc'], 'ok');
		}
		cot_redirect(cot_url('costcalculator', array('m'=> 'fill', 'id' => $id), '', true));
	}

	$cc = $db->query("SELECT * FROM $db_cc_calcs WHERE cc_id=".$id)->fetch();	

	$groups = explode(',', $cc['cc_groups']);	
	if(!in_array($usr['maingrp'], $groups)){ //заборона відкривати калькулятор щщо не дозволено для групи
		cot_redirect(cot_url('message', "msg=930", '', true));
		exit;
	}

	//сео
	$out['subtitle'] = $cc['cc_name'];
	$out['desc'] = cot_string_truncate($cc['cc_desc'], 255);
	$out['keywords'] = $L['cc_keywords'];

	$mskin = cot_tplfile(array('costcalculator', 'fill'), 'plug');
	$t = new XTemplate($mskin);

	$sqllist = $db->query("SELECT * FROM $db_cc_calcs_rows WHERE cc_id=".$id)->fetchAll();

	//дістаємо всю заповненну інформацію якщо є
	$sqlcost = $db->query("SELECT cu.*
							FROM $db_cc_calcs_users_cost AS cu
							LEFT JOIN $db_cc_calcs_rows AS cr ON cu.ccr_id = cr.ccr_id 
							WHERE cr.cc_id=".$id."
							AND cu.ccu_user_id=".$usr['id'])->fetchAll();

	if(count($sqlcost) > 0){
		foreach ($sqlcost as $value) { //змінити масив щоб зручніше вибирати дані
	 		$ccr[$value['ccr_id']] = $value;
	 	}
	}
	$currency = (isset($cfg['payments']['valuta']) && !empty($cfg['payments']['valuta'])) ? $cfg['payments']['valuta'] : $cfg['plugin']['costcalculator']['cc_currency'] ;
	foreach ($sqllist as $row) {
		$t->assign(array(
			'CCR_ROW_ID'  => $row['ccr_id'],
			'CCR_ROW_NAME'  => $row['ccr_name'],
			'CCR_ROW_DESC'  => $row['ccr_desc'],
			'CCR_ROW_INPUT'  => cot_inputbox('number', 'inp['.$row["ccr_id"].']', ($ccr[$row['ccr_id']]['ccu_cost']) ? $ccr[$row['ccr_id']]['ccu_cost'] : 0, array('size' => 4, 'maxlength' => 50, 'step' => '0.01')),
			'CCR_ROW_UNITS'  => $currency." / ".$row['ccr_units']
		));
		$t->parse('MAIN.CCR_ROW');
	}

	$currentbrc[] = array(cot_url('costcalculator', 'm=fill'), $L['cc_fill_calculate']);
	$currentbrc[] = array(cot_url('costcalculator', 'm=fill&id='.$cc['cc_id']), $cc['cc_name']);
	$patharray = array_merge($patharray, $currentbrc);
	$bdcrpath = cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true);

	$t->assign(array(
			'CC_ID'  => $cc['cc_id'],
			'CC_NAME'  => $cc['cc_name'],
			'CC_DESC'  => $cc['cc_desc'],
			'FORM_ACTION' => cot_url('index', 'r=costcalculator'),
			'CC_DELETE_URL' => cot_url('costcalculator', array('m'=> 'fill', 'id' => $cc['cc_id'], 'a' => 'delete')),
			'BREADCRUMBS' => $bdcrpath
		));

}else{  //якщо немає ID для заповнення

	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['costcalculator']['cc_rowsperpage']);

	//сео
	$out['subtitle'] = $L['info_name'];
	$out['desc'] = $L['info_desc'];
	$out['keywords'] = $L['cc_keywords'];

	//шаблон
	$mskin = cot_tplfile(array('costcalculator', 'fill.list'), 'plug');
	$t = new XTemplate($mskin);

	$sqllist = $db->query("SELECT c.*, 
	         				COUNT(DISTINCT cr.ccr_id) AS cc_row_count,
	        				COUNT(DISTINCT cu.ccu_user_id) AS ur_specialists
	    					FROM $db_cc_calcs AS c
	    					INNER JOIN $db_cc_calcs_rows AS cr ON c.cc_id = cr.cc_id 
	   						LEFT OUTER JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
							GROUP BY c.cc_id
							HAVING cc_row_count > 0
							AND c.cc_groups LIKE '%".$usr['maingrp']."%'
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

	//пагінація
	$totalitems = $db->query("SELECT COUNT(*) FROM $db_cc_calcs WHERE cc_groups LIKE '%".$usr['maingrp']."%'")->fetchColumn();
	$list_url_path = array ('e' => 'costcalculator', 'm' => 'fill');
	$pagenav = cot_pagenav('costcalculator', $list_url_path, $d, $totalitems, $cfg['plugin']['costcalculator']['cc_rowsperpage']);
	
	$currentbrc[] = array(cot_url('costcalculator', 'm=fill'), $L['cc_fill_calculate']);
	$patharray = array_merge($patharray, $currentbrc);	
	$bdcrpath = cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true);

	$t->assign(array(
		"PAGENAV_PAGES" => $pagenav['main'],
		"PAGENAV_PREV" => $pagenav['prev'],
		"PAGENAV_NEXT" => $pagenav['next'],
		"PAGENAV_COUNT" => $totalitems,
		"BREADCRUMBS" => $bdcrpath
	));	
}

//повідомлення
	cot_display_messages($t);