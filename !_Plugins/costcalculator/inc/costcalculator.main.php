<?php defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'costcalculator', 'RWA');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$inp = cot_import('inp', 'P', 'ARR'); //отримуємо масив заповненних полей для калькулятора
$orderlist = cot_import('orderlist', 'P', 'INT');
$orderlist = (!isset($orderlist) || empty($orderlist)) ? 0 : $orderlist ;
if(!empty($inp)){
	foreach ($inp as $key => $value) {	
		$inp[$key] = abs((float)$value);
	}
}
//сео
$out['subtitle'] = $L['info_name'];
$out['desc'] = $L['info_desc'];
$out['keywords'] = $L['cc_keywords'];

//шаблон
$mskin = cot_tplfile(array('costcalculator', 'main'), 'plug');
$t = new XTemplate($mskin);

$sqllist = $db->query("SELECT * FROM $db_cc_calcs_rows WHERE cc_id={$id} ORDER BY ccr_order ASC")->fetchAll();

//рядки
foreach ($sqllist as $row) {

	$t->assign(array(
		'CCR_ROW_ID'  => $row['ccr_id'],
		'CCR_ROW_NAME'  => $row['ccr_name'],
		'CCR_ROW_DESC'  => $row['ccr_desc'],
		'CCR_ROW_INPUT'  => cot_inputbox('number', 'inp['.$row["ccr_id"].']', ($inp[$row['ccr_id']]) ? $inp[$row['ccr_id']] : 0, array('size' => 4, 'maxlength' => 50, 'step' => '0.01')),
		'CCR_ROW_UNITS'  => $row['ccr_units']
	));
	$t->parse('MAIN.CCR_ROW');
}

$sqlcc = $db->query("SELECT * FROM $db_cc_calcs WHERE cc_id={$id}")->fetch();

$sortparam = array(
					0=>'Сортировать: Нет',
					1=>'Актуальности цен',
					2=>'Общей стоимости',
					);
$t->assign(array(
		'CC_ID'  => $sqlcc['cc_id'],
		'CC_NAME'  => $sqlcc['cc_name'],
		'CC_DESC'  => $sqlcc['cc_desc'],
		'CC_SORTLIST' => cot_selectbox($orderlist, 'orderlist', array_keys($sortparam), array_values($sortparam), false),
		'FORM_ACTION' => cot_url('costcalculator', 'id='.$sqlcc['cc_id'],'',true)
	));

//список спеціалістів по калькулятору
$sqluserall = $db->query("SELECT cu.ccu_user_id
							FROM $db_cc_calcs_users_cost AS cu
   							LEFT JOIN $db_cc_calcs_rows AS cr ON cu.ccr_id = cr.ccr_id
							WHERE cr.cc_id={$id} 
							GROUP BY cu.ccu_user_id
							LIMIT 0, ".(int)$cfg['plugin']['costcalculator']['cc_count_users'])->fetchAll(PDO::FETCH_COLUMN);
if(count($sqluserall) > 0){
	$costdatalist = cot_cc_get_users_cost_data($id,$sqluserall,$inp);

	switch ($orderlist) {
		case 1:
			uasort($costdatalist, 'cot_cc_sort_by_cost');
			break;
		case 2:
			uasort($costdatalist, 'cot_cc_sort_by_lastupdate');
			break;		
		default:
			# code...
			break;
	}	

	foreach ($costdatalist as $user_id => $value) {
		# розрахунок по кожному користувачу
		$t->assign(cot_generate_usertags($user_id, 'CCU_ROW_USER_'));
		$t->assign(cot_cc_generate_usertags_list($value, 'CCU_ROW_'));	
		$t->parse('MAIN.CCU_ROW');
	}
}
$t->assign(array(
		'CC_USERCOUNT'  => count($sqluserall)
	));

cot_display_messages($t);