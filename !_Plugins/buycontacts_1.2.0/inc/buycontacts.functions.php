<?php defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('buycontacts', 'plug');

function cot_contact_isbought($prj_id,$user_id=''){

	global $usr, $db, $db_projects_offers, $db_projects;

	if(empty($prj_id) || !is_numeric($prj_id) || $prj_id < 0)
		return false;

	$user_id = (!empty($user_id) && is_numeric($user_id) && $user_id > 0 ) ? $user_id : (isset($usr['profile']['user_id'])) ? $usr['profile']['user_id'] : false ;

	if($user_id == false)
		return false;

	//якщо це автор проекту то показуємо контакти
	$prjauthor = $db->query("SELECT item_userid FROM $db_projects WHERE item_id={$prj_id}")->fetchColumn();
	 if($prjauthor == $user_id)
	 	return true; 
	
	 //Перевірка чи куплений контакт по проекту $prj_id
	$isbought = $db->query("SELECT offer_buycontacts FROM $db_projects_offers WHERE offer_pid={$prj_id} AND offer_userid={$user_id}")->fetchColumn();
	return ($isbought == 1) ? true : false ;
}

function cot_contact_getcost($prj_id,$user_id=''){

	global $usr, $cfg, $db, $db_projects, $db_projects_offers;

	if(empty($prj_id) || !isset($prj_id))
		return false;
	$user_id = (!empty($user_id) && is_numeric($user_id) && $user_id > 0 ) ? $user_id : (isset($usr['profile']['user_id'])) ? $usr['profile']['user_id'] : false ;

	$prj = $db->query("SELECT p.item_cost, p.item_performer, o.offer_cost_min, o.offer_cost_max
						FROM $db_projects AS p
						LEFT JOIN $db_projects_offers AS o ON o.offer_pid = p.item_id
						WHERE p.item_id={$prj_id} 
						AND o.offer_userid={$user_id}")->fetch();
	
	switch ($cfg['plugin']['buycontacts']['bc_fromcost']) {
		case 'item_cost':
			$costforcalc = $prj['item_cost'];
			break;			
		case 'offer_cost_min':
			$costforcalc = $prj['offer_cost_min'];
			break;	
		case 'offer_cost_max':
			$costforcalc = $prj['offer_cost_max'];
			break;		
		default:
			$costforcalc = $prj['item_cost'];
			break;
	}
	//отримуємо число для розрахунку вартості, якщо виконавець то одна цифра або інакша
	if($user_id == $usr['profile']['user_id']) {
		$forformula = cot_contact_getpercent($costforcalc);
	}else{
		return false;
	}

	$summforbuy = ($cfg['plugin']['buycontacts']['bc_ispercent']) ? $costforcalc/100*$forformula : $forformula ;	

	return ((int)$cfg['plugin']['buycontacts']['bc_mincost'] > 0 && $summforbuy < (int)$cfg['plugin']['buycontacts']['bc_mincost']) ? $cfg['plugin']['buycontacts']['bc_mincost'] : $summforbuy ;
}

function cot_contact_getparam($prj_id){

	global $usr, $db, $db_projects, $db_projects_offers;

	if(isset($usr['profile']['user_id'])) {
		$user_id = $usr['profile']['user_id'];
	} else { 
		return false; 
	}

	return $db->query("SELECT p.item_title AS prj_title, p.item_alias AS prj_alias, p.item_cat AS prj_cat, o.item_id AS offer_id 
							FROM $db_projects AS p
							LEFT JOIN $db_projects_offers AS o ON o.item_pid = p.item_id
							WHERE o.item_userid = {$user_id} AND p.item_id = {$prj_id} ")->fetch();	

}


function cot_contact_getpercent($cost){
	global $cfg;
	$parsecfgtmp = str_replace("\r\n", "\n", $cfg['plugin']['buycontacts']['bc_formula_performer']);
	$parsecfg = explode("\n", $parsecfgtmp);
	foreach ($parsecfg as $lineset)
	{
		list($cost_min,$cost_max,$commission) = explode("|", $lineset);
		$cost_min = (int)trim($cost_min);
		$cost_max = (int)trim($cost_max);
		$commission = (float)trim($commission);
			if($cost > $cost_min && $cost < $cost_max){
				return $commission;
				exit;
			}
		}
	return $cfg['plugin']['buycontacts']['bc_formula_def'];
}

function cot_contact_fromcost(){
	global $L;
	$arraytmp = array(
		'item_cost'=>'Стоимость проекта',
		'offer_cost_min'=>'Сумма предложение исполнителя (от)',
		'offer_cost_max'=>'Сумма предложение исполнителя (до)',
		//'offer_cost'=>'Сумма в предложении'
		);
	$L['cfg_bc_fromcost_params'] = array_values($arraytmp);
	return array_keys($arraytmp);
}