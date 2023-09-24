<?php defined('COT_CODE') or die('Wrong URL');

$cc_id = cot_import('cc_id', 'R', 'INT');

$adminpath[] = $L['cc_configcalc'];

if ($a == 'add')
{
	// form handler
	$ccrow['cc_id'] = $cc_id;
	$ccrow['ccr_name'] = cot_import('ccr_name', 'P', 'TXT');
	$ccrow['ccr_desc'] = cot_import('ccr_desc', 'P', 'HTM');
	$ccrow['ccr_units'] = cot_import('ccr_units', 'P', 'TXT');
	$ccrow['ccr_order'] = cot_import('ccr_order', 'P', 'INT');

	cot_check(empty($ccrow['ccr_name']), $L['cc_err_empty_name']);	
	cot_check(empty($ccrow['ccr_units']), $L['cc_err_empty_units']);	

	if (!cot_error_found())
	{
		cot_cc_add_calc_row($ccrow);
		cot_message($L['Added'], 'ok');
		// Return to the main page and show messages
		cot_redirect(cot_url('admin', 'm=other&p=costcalculator&n=configcalc&cc_id='.$cc_id, '', true));
	}
	
}
//save changes
if($a == 'update'){
	// form handler
	$data = cot_import('data', 'P', 'ARR');
	$cr = 0;
	foreach ($data as $key => $value) {
		if(cot_cc_update_calc_row($key, $value)){
			$cr++;
		}
	}	
	cot_message($L['Updated']." (".$cr.")", 'ok');
	// Return to the main page and show messages
	cot_redirect(cot_url('admin', 'm=other&p=costcalculator&n=configcalc&cc_id='.$cc_id, '', true));
}

//save changes
if($a == 'delete'){
	// form handler	
	if($id > 0){
		cot_cc_delete_calc_row($id);
		cot_message($L['Deleted'], 'ok');
		// Return to the main page and show messages
		cot_redirect(cot_url('admin', 'm=other&p=costcalculator&n=configcalc&cc_id='.$cc_id, '', true));
	}	
}

$tt = new XTemplate(cot_tplfile('costcalculator.tools.configcalc', 'plug'));

cot_display_messages($tt);

// Display the main page
$sqllist = $db->query(" SELECT * FROM $db_cc_calcs_rows WHERE cc_id=".$cc_id." ORDER BY ccr_order ASC")->fetchAll();

foreach ($sqllist as $row) {
	$jj++;
	$tt->assign(array(
		'CCR_ROW_ID'  => $row['ccr_id'],
		'CCR_ROW_NAME'  => cot_inputbox('text', 'data['.$row['ccr_id'].'][ccr_name]', $row['ccr_name'], array('size' => 56, 'maxlength' => 255)),
		'CCR_ROW_DESC'  => cot_textarea('data['.$row['ccr_id'].'][ccr_desc]', $row['ccr_desc'], 2, 30),
		'CCR_ROW_UNITS' => cot_inputbox('text', 'data['.$row['ccr_id'].'][ccr_units]', $row['ccr_units'], array('size' => 56, 'maxlength' => 255)),
		'CCR_ROW_ORDER' => cot_inputbox('text', 'data['.$row['ccr_id'].'][ccr_order]', $row['ccr_order'], array('size' => 3, 'maxlength' => 4)),
		'CCR_ROW_DELETE' => cot_confirm_url(cot_url('admin', 'm=other&p=costcalculator&n=configcalc&a=delete&cc_id='.$cc_id.'&id='. $row['ccr_id']),'costcalculator')
	));
	$tt->parse('MAIN.CCR_ROW');
}
$tt->assign('CCR_ROWS_COUNT', $jj);
$tt->assign('CCR_ROWS_ACTION_UPDATE', cot_url('admin', 'm=other&p=costcalculator&n=configcalc&a=update&cc_id='.$cc_id));
// From to add new calc row
$tt->assign(array(
	'CCR_FORM_ACTION' => cot_url('admin', 'm=other&p=costcalculator&n=configcalc&a=add&cc_id='.$cc_id),
	'CCR_NAME'  => cot_inputbox('text', 'ccr_name', $ccrow['ccr_name'], array('size' => 56, 'maxlength' => 255, 'class' => 'input-small', 'placeholder' => $L['cc_title'])),
	'CCR_DESC'  => cot_textarea('ccr_desc', $ccrow['ccr_desc'], 3, 30, array('placeholder' => $L['cc_desc']), ''),
	'CCR_ORDER' => cot_inputbox('text', 'ccr_order', $ccrow['ccr_order'], array('size' => 4, 'maxlength' => 255, 'class' => 'input-small', 'placeholder' => '№')),
	'CCR_UNITS' => cot_inputbox('text', 'ccr_units', $ccrow['ccr_units'], array('size' => 4, 'maxlength' => 255, 'class' => 'input-small', 'placeholder' => $L['cc_units']))
));

$tt->parse();
$plugin_body = $tt->text('MAIN');