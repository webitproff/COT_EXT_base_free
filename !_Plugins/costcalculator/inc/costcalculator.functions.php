<?php defined('COT_CODE') or die('Wrong URL');
#Ніколи не пишіть код без проектування
#Никогда не пишите код без проектирования
#Never write code without design
require_once cot_langfile('costcalculator', 'plug');

// Registering tables
cot::$db->registerTable('cc_calcs');
cot::$db->registerTable('cc_calcs_rows');
cot::$db->registerTable('cc_calcs_users_cost');

function cot_cc_delete_calc($id){	
	global $db, $db_cc_calcs, $db_cc_calcs_rows;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}

	$id = (int)$id;
	//видалити конфіг користувачів
	$db->delete($db_cc_calcs_rows, "cc_id = ?", $id);
	$db->delete($db_cc_calcs, "cc_id = ?", $id);
	cot_log("Deleted calc #" . $id, 'adm');
	return true;
}

function cot_cc_add_calc($calc){
	global $db, $db_cc_calcs;

	if (cot_error_found()){
		return false;
	}

	if ($db->insert($db_cc_calcs, $calc)){
		$id = $db->lastInsertId();
	}else{
		$id = false;
	}

	cot_shield_update(30, "r calcs");
	cot_log("Add calc #".$id, 'adm');

	return $id;
}

function cot_cc_update_calc($id, $calc){
	global $db, $db_cc_calcs;

	if (!$db->update($db_cc_calcs, $calc, 'cc_id = ?', $id))
	{
		return false;
	}
	return true;
}


/*  functions for calc rows */

function cot_cc_delete_calc_row($id){	
	global $db, $db_cc_calcs_rows;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}

	$id = (int)$id;

	$db->delete($db_cc_calcs_rows, "ccr_id = ?", $id);
	cot_log("Deleted calc row #" . $id, 'adm');
	return true;
}

function cot_cc_add_calc_row($row){
	global $db, $db_cc_calcs_rows;

	if (cot_error_found()){
		return false;
	}

	if ($db->insert($db_cc_calcs_rows, $row)){
		$id = $db->lastInsertId();
	}else{
		$id = false;
	}

	cot_shield_update(30, "r calc rows");
	cot_log("Add calc rows #".$id, 'adm');

	return $id;
}

function cot_cc_update_calc_row($id, $row){
	global $db, $db_cc_calcs_rows;

	if (!$db->update($db_cc_calcs_rows, $row, 'ccr_id = ?', $id))
	{
		return false;
	}
	return true;
}


function cot_cc_isfill($cc_id, $user_id=''){
	global $usr, $db, $db_cc_calcs, $db_cc_calcs_rows, $db_cc_calcs_users_cost;

	if(empty($cc_id) || !is_numeric($cc_id)){
		return false;
	}

	$user_id = (!empty($user_id) && $user_id > 0) ? $user_id : $usr['id'] ;

	$sql = $db->query("SELECT COUNT(DISTINCT cu.ccu_user_id) AS isfillcalc
		    					FROM $db_cc_calcs AS c
		    					INNER JOIN $db_cc_calcs_rows AS cr ON c.cc_id = cr.cc_id 
		   						LEFT OUTER JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
								WHERE c.cc_id=".$cc_id."
								AND cu.ccu_user_id=".$user_id)->fetch();
	return (int)$sql['isfillcalc'];
}

function cot_cc_generate_usertags_list($arraydata, $prefix=''){
	global $cfg;

	if(empty($arraydata) || !is_array($arraydata)){
		return false;
	}

	@uasort($arraydata, function($f, $s){

		if ($f['ccr_order'] == $s['ccr_order']) {
		    return 0;
		}
		return ($f['ccr_order'] < $s['ccr_order']) ? -1 : 1;
	});
 	// потрібно підключити шаблон для списку полів
 	$mskin = cot_tplfile(array('costcalculator', 'user', 'costlist'), 'plug');
 	$cl = new XTemplate($mskin);

 	$currency 	= (isset($cfg['payments']['valuta']) && !empty($cfg['payments']['valuta'])) ? $cfg['payments']['valuta'] : $cfg['plugin']['costcalculator']['cc_currency'] ;
	$summ 		= 0;
	$lastupdate = 0;
 	foreach ($arraydata as $key => $value) { // прогнати масив по полям
 		if($key == 'ccu_costcalcsumm'){
 			$summ+= $value; 
 			continue;
 		}
 		if($key == 'ccu_lastupdate'){
 			$lastupdate = $value; 
 			continue;
 		}
 		
 		$cl->assign(array(
 			'CC_ROW_NAME'	 	=> $value['ccr_name'],
 			'CC_ROW_COST' 		=> $value['ccu_cost'],
 			'CC_ROW_CALCCOST'	=> ($value['ccu_costcalc']) ? $value['ccu_costcalc'] : 0 ,
 			'CC_ROW_UNITS' 		=> $currency."/".$value['ccr_units'],
 			'CC_ROW_UPDATED' 	=> $value['ccu_updated'],
 			'CC_ROW_CURRENCY'	=> $currency
 		));
 		$cl->parse('MAIN.CC_ROW_USERCOST');
 	}
 	$cl->assign(array(
 			'CC_LASTUPDATE'	 	=> $lastupdate,
 			'CC_SUMM'			=> $summ,
 			'CC_CURRENCY'		=> $currency
 		));

 	$cl->parse('MAIN');

	$temp_array = array(
		'COSTLIST' => $cl->text('MAIN')
	);

	foreach ($temp_array as $key => $val)
	{
		$return_array[$prefix . $key] = $val;
	}
	return $return_array;
}

function cot_cc_get_users_cost_data($cc_id,$users_list,$inp){

	global $db, $L, $cfg, $db_cc_calcs_rows, $db_cc_calcs_users_cost;

		//всі поля для калькулятора
		$sqlccr = $db->query("SELECT * FROM $db_cc_calcs_rows WHERE cc_id={$cc_id} ORDER BY ccr_order")->fetchAll();
		$forselect = array();
		foreach ($sqlccr as $value) { //змінити масив щоб зручніше вибирати дані
	 		$ccr[$value['ccr_id']] = $value;
	 		$forselect[] = $value['ccr_id']; 		
	 	}

	 	//всі заповненні поля по калькулятору для пористувача
	 	$sqlcostuser = $db->query("SELECT uc.ccu_user_id AS uid, uc.* FROM $db_cc_calcs_users_cost AS uc
	 								WHERE uc.ccr_id IN (".implode(',',$forselect).") 
	 								AND uc.ccu_user_id IN (".implode(',',$users_list).") 
	 								")->fetchAll(PDO::FETCH_GROUP); 	
	 	
	 	foreach ($sqlcostuser as $key => $ccrvalue) { //змінити масив щоб зручніше вибирати дані	 	
	 		foreach ($ccrvalue as $value) {
	 			$ccu[$key][$value['ccr_id']] = $value;
	 		} 		
	 	}
	 	unset($sqlcostuser); // зайвий
	 	array_walk($ccu, function(&$array,$key,$ccr){

	 		foreach ($ccr as $keyr => $valuer) {
	 			if (array_key_exists($keyr, $array)) {
	 				$array[$keyr] = $array[$keyr] + $valuer;	 			    
	 			}else{
	 				$array[$keyr] = $valuer;
	 				$array[$keyr]['ccu_user_id'] = $key;
	 				$array[$keyr]['ccu_cost'] = 0;
	 				$array[$keyr]['ccu_updated'] = 0;
	 				$array[$keyr]['ccu_id'] = NULL;	 				
	 			}
	 		}
	 	
	 	},$ccr);

	 	if(!empty($inp) || is_array($inp)){
	 		foreach ($inp as $key => $value) {
	 			foreach ($ccu as $user_id => &$ccr_id_array) {
	 				$ccu[$user_id]['ccu_costcalcsumm'] += $ccr_id_array[$key]['ccu_costcalc'] =  $ccr_id_array[$key]['ccu_cost'] * $value;
	 				//дата актуальності цін (виводитьс тільки при розрахунку, потрібно поправити потім)	 
	 				$ccu[$user_id]['ccu_lastupdate'] = ($ccu[$user_id]['ccu_lastupdate'] < $ccr_id_array[$key]['ccu_updated']) ? $ccr_id_array[$key]['ccu_updated'] : $ccu[$user_id]['ccu_lastupdate'] ;			
	 			}
	 		}
	 	}
 return $ccu;
}

/*
* sort function
 */
function cot_cc_sort_by_cost($a, $b) {
    if ($a['ccu_costcalcsumm'] == $b['ccu_costcalcsumm']) {
        return 0;
    }
    return ($a['ccu_costcalcsumm'] < $b['ccu_costcalcsumm']) ? -1 : 1;
}
function cot_cc_sort_by_lastupdate($a, $b) {
    if ($a['ccu_lastupdate'] == $b['ccu_lastupdate']) {
        return 0;
    }
    return ($a['ccu_lastupdate'] < $b['ccu_lastupdate']) ? -1 : 1;
}