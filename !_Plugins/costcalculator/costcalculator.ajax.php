<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

if(COT_AJAX){

		$cc_id = cot_import('cc_id', 'P', 'INT');
		(empty($cc_id)) ? exit : '' ; //вмираємо якщо немає ІД для калькулятора

		$inp = cot_import('inp', 'P', 'ARR'); //отримуємо масив заповненних полей для калькулятора
	 	$ccrtmp = $db->query("SELECT * FROM $db_cc_calcs_rows WHERE cc_id=".$cc_id)->fetchAll(); //кількість полей калькулятора в БД
	 	$countrow = count($ccrtmp); //запишемо кількість рядків для подальшого порівняння

	 	$ccr = array();
 	 	foreach ($ccrtmp as $value) { //змінити масив щоб зручніше вибирати дані
	 		$ccr[$value['ccr_id']] = $value;
	 	}

	 	foreach ($inp as $key => $value) {
	 		if(empty($value) || $value <= 0){
	 			$emptyrow[$key] = $ccr[$key]['ccr_name'];
	 			unset($inp[$key]);	 			
	 		}	 		
	 	}
	 	
	 	if(count($inp) != $countrow){	 		
	 		foreach ($emptyrow as $value) {
	 			$messgerr .= "<br>'".$value."'";
	 		}
	 		echo cot_rc('cc_err_empty_row', array('rows' => $messgerr));	//спик пустих полів 		 
	 	}else{
	 		array_walk($inp, function(&$r){  (float)$r; });
	 	
	 		$sqlforupdate = $db->query("SELECT cu.ccr_id
		 								FROM $db_cc_calcs_users_cost AS cu
		 								LEFT JOIN $db_cc_calcs_rows AS cr ON cu.ccr_id = cr.ccr_id 
		 								WHERE cr.cc_id={$cc_id}
		 								AND cu.ccu_user_id=".$usr['id'])->fetchAll();
	 	 	foreach ($sqlforupdate as $value) { //змінити масив щоб зручніше вибирати дані
		 		$indb[$value['ccr_id']] = $value;
		 	}
	 		$inst = array();
	 		foreach ($inp as $key => $value) {
	 			if(isset($indb[$key])){
	 				$update = array(
	 							'ccu_cost' => $inp[$key],
	 							'ccu_updated' => $sys['now']
	 							);	 				
	 				$result += ($db->update($db_cc_calcs_users_cost, $update, "ccr_id=".$key." AND ccu_user_id=".$usr['id']." LIMIT 1") != false)? 1 : 0 ;	 				
	 			}else{
	 				$inst[] = "({$key}, {$usr['id']}, {$value}, {$sys['now']})";	 		
	 			}
	 		}
	 		//виводимо інформацуію про кількість оновлених рядків
	 		echo (isset($result) && count($result) > 0 ) ?  "<div class='alert alert-success'>".$L['Updated']." ".$result."</div>" : '' ;

	 		if(count($inst) > 0 ){	 			
	 			$db->query("INSERT INTO $db_cc_calcs_users_cost (`ccr_id`, `ccu_user_id`, `ccu_cost`, `ccu_updated`) VALUES ".implode(',',$inst));
	 			echo "<div class='alert alert-success'>".$L['Added']."</div>";
	 		}	 		
	 	}
}