<?php defined('COT_CODE') or die('Wrong URL');
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */
require_once cot_incfile('costcalculator', 'plug');

$tab = cot_import('tab', 'G', 'ALP');
list($pg, $d, $durl) = cot_import_pagenav('dcc', $cfg['plugin']['costcalculator']['cc_rowsperpage']);

//вкладка
$t1 = new XTemplate(cot_tplfile(array('costcalculator','userdetails'), 'plug'));

$t1->assign(array(
	"FILLCC_URL" => cot_url('costcalculator', 'm=fill'),
	"FILLCC_SHOWBUTTON" => ($usr['id'] < 1) ? 0 : $db->query("SELECT COUNT(*) as caclforfill FROM $db_cc_calcs WHERE cc_groups LIKE '%".$usr['maingrp']."%'")->fetchColumn()
));

/* === Hook === */
foreach (cot_getextplugins('costcalculator.userdetails.query') as $pl)
{
	include $pl;
}
/* ===== */

/*=================================*/
$sqllist = $db->query("SELECT c.* 
    					FROM $db_cc_calcs AS c
    					LEFT JOIN $db_cc_calcs_rows AS cr ON c.cc_id = cr.cc_id 
   						LEFT JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
   						WHERE cu.ccu_user_id = ".$urr['user_id']."
						GROUP BY c.cc_id
						HAVING COUNT(cr.ccr_id) > 0
						ORDER BY c.cc_order ASC 
						LIMIT $d, " . $cfg['plugin']['costcalculator']['cc_rowsperpage'])->fetchAll();


$sqlcount = $db->query("SELECT COUNT(DISTINCT c.cc_id)
    					FROM $db_cc_calcs AS c
    					LEFT JOIN $db_cc_calcs_rows AS cr ON c.cc_id = cr.cc_id 
   						LEFT JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
   						WHERE cu.ccu_user_id = ".$urr['user_id']."   						
						HAVING COUNT(cr.ccr_id) > 0")->fetch(PDO::FETCH_COLUMN);
$sqlcount = (empty($sqlcount) || $sqlcount < 0) ? 0 : $sqlcount ;
/*=================================*/


/* === Hook === */
$extpcc = cot_getextplugins('costcalculator.userdetails.loop.cc');
$extpccr = cot_getextplugins('costcalculator.userdetails.loop.ccr');
/* ===== */
if($sqlcount){

	//зібрати ІД калькуляторів для вибірки
	$forselect = array();
	foreach ($sqllist as $value) {
		$forselect[] = $value['cc_id'];
	}
	//вибрати рядки по кожному калькулятору що щаповнив користувач
	$sqlrows = $db->query("SELECT cr.cc_id, cu.*,	cr.*
	    					FROM $db_cc_calcs_rows AS cr
	   						LEFT JOIN $db_cc_calcs_users_cost AS cu ON cu.ccr_id = cr.ccr_id
	   						WHERE cu.ccu_user_id = ".$urr['user_id']."
	   						AND cr.cc_id IN (".implode(',',$forselect).")							
							ORDER BY cr.ccr_order ASC")->fetchAll(PDO::FETCH_GROUP);

	foreach($sqllist as $cc_item)
	{
		$t1->assign(array(
			"CC_ID" 	=>  $cc_item['cc_id'],
			"CC_URL"	=> cot_url('costcalculator','id='.$cc_item['cc_id']),
			"CC_NAME" 	=> $cc_item['cc_name'],
			"CC_DESC" 	=> $cc_item['cc_desc'],
			"CC_GROUPS" => $cc_item['cc_groups']
			));

			foreach ($sqlrows[$cc_item['cc_id']] as $value) {

				$t1->assign(array(
					"CCR_ID" 		=> $value['ccr_id'],				
					"CCR_NAME" 		=> $value['ccr_name'],
					"CCR_DESC" 		=> $value['ccr_desc'],
					"CCR_UNITS" 	=> $value['ccr_units'],
					"CCR_COST" 		=> $value['ccu_cost'],
					"CCR_CURRENCY" 	=>  (isset($cfg['payments']['valuta']) && !empty($cfg['payments']['valuta'])) ? $cfg['payments']['valuta'] : $cfg['plugin']['costcalculator']['cc_currency']
					));

				/* === Hook === */
				foreach ($extpccr as $pl)
				{
					include $pl;
				}
				/* ===== */

				$t1->parse("MAIN.CC_ROWS.CCR_ROWS");
			}

		/* === Hook === */
		foreach ($extpcc as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t1->parse("MAIN.CC_ROWS");
	}
}
$opt_array = array(
					'm' => 'details',
				  	'id'=> $urr['user_id'],
				  	'u'=> $urr['user_name'],
				    'tab' => 'costcalculator'
				    );

$pagenav = cot_pagenav('users',$opt_array , $d, $sqlcount, $cfg['plugin']['costcalculator']['cc_rowsperpage'], 'dcc');

$t1->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $sqlcount,
));

	/* === Hook === */
	foreach (cot_getextplugins('costcalculator.userdetails.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

$t1->parse("MAIN");

$t->assign(array(
	"USERS_DETAILS_CC_COUNT" => $sqlcount,
	"USERS_DETAILS_CC_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=costcalculator'),
));

$t->assign('COSTCALCULATOR', $t1->text("MAIN"));