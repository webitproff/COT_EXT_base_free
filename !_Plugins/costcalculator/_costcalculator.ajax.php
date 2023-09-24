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
	 	//$inp = array_filter($inp, function($r){ return (!empty($r) && $r > 0) ? true : false; }); // видаляємо пусті значення масива
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

	 		
	 		print_r($sqlforupdate);
	 		$inst = array();
	 		foreach ($inp as $key => $value) {
	 			echo $value['ccr_id'];
	 			if(isset($sqlforupdate[$value['ccr_id']])){
	 				$update = array(
	 							'ccu_cost' => $inp[$value['ccr_id']],
	 							'ccu_updated' => $sys['now']
	 							);
	 				
	 				//$result = $db->update($db_cc_calcs_users_cost, $update, "ccr_id=".$key." AND ccu_user_id=".$usr['id']." LIMIT 1");
	 			}else{
	 				$inst[] = "({$value['ccr_id']}, {$usr['id']}, {$inp[$value['ccr_id']]}, 0)";	 		
	 			}
	 		}

	 		if($inst != false && count($inst) > 0 ){
	 			print_r($inst);
	 			//$db->query("INSERT INTO $db_cc_calcs_users_cost (`ccr_id`, `ccu_user_id`, `ccu_cost`, `ccu_updated`) VALUES ".implode(',',$inst));
	 			echo "<div class='alert alert-success'>".$L['Updated']."</div>";
	 		}
			/*$ifupdate = $db->query("SELECT COUNT(*) as rcount 
				 					FROM $db_cc_calcs_users_cost 
				 					WHERE ccr_id IN (".implode(',',array_keys($inp)).") 
				 					AND ccu_user_id=".$usr['id'])->fetch();
			
	 		if($ifupdate['rcount'] > 0){
	 				foreach ($inp as $key => $value) {
		 				$update = array(
		 							'ccu_cost' => $value,
		 							'ccu_updated' => $sys['now']
		 							);
		 				$result = $db->update($db_cc_calcs_users_cost, $update, "ccr_id=".$key." AND ccu_user_id=".$usr['id']." LIMIT 1");
	 				}
	 				echo "<div class='alert alert-success'>".$L['Updated']."</div>";
	 		}else{
	 			foreach ($inp as $key => $value) {
	 				$inst[] = "({$key}, {$usr['id']}, {$value}, 0)";
	 			}
	 			$db->query("INSERT INTO $db_cc_calcs_users_cost (`ccr_id`, `ccu_user_id`, `ccu_cost`, `ccu_updated`) VALUES ".implode(',',$inst));
	 			echo "<div class='alert alert-success'>".$L['Updated']."</div>";
	 		}*/
	 		
	 	}
}