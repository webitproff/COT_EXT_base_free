<?php defined('COT_CODE') or die('Wrong URL');

if ($a == 'delete' && !empty($id)) {
	cot_cc_delete_calc($id);
	cot_message($L['Deleted'], 'ok');
	// Return to the main page and show messages
	cot_redirect(cot_url('admin', 'm=other&p=costcalculator', '', true));
}

$tt = new XTemplate(cot_tplfile('costcalculator.tools', 'plug'));

cot_display_messages($tt);

// Display the main page $db_cc_calcs_rows  
$sqllist = $db->query(" SELECT c.*, COUNT(r.ccr_id) AS cc_row_count 
						FROM $db_cc_calcs AS c 
						LEFT JOIN $db_cc_calcs_rows AS r ON c.cc_id = r.cc_id 
						GROUP BY c.cc_id 
						ORDER BY c.cc_order ASC")->fetchAll();

foreach ($sqllist as $row) {
	$groups = $groupslist = array();
	$groups = explode(',', $row['cc_groups']);
	foreach ($groups as $grpid) {
		$groupslist[$grpid]= $cot_groups[$grpid]['title'];
	}
	$tt->assign(array(
		'CC_ROW_ID'  => $row['cc_id'],
		'CC_ROW_NAME'  => $row['cc_name'],
		'CC_ROW_DESC'  => $row['cc_desc'],
		'CC_ROW_GROUP' => implode(', ',$groupslist),
		'CC_ROW_NUMROW' => $row['cc_row_count']
	));
	$tt->parse('MAIN.CC_ROW');
}

$tt->parse();
$plugin_body = $tt->text('MAIN');