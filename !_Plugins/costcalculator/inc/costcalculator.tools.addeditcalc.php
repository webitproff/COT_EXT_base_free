<?php defined('COT_CODE') or die('Wrong URL');

$adminpath[] = $L['cc_newcalc'];

if ($a == 'add')
{
	// form handler
	$calc['cc_name'] = cot_import('cc_name', 'P', 'TXT');
	$calc['cc_desc'] = cot_import('cc_desc', 'P', 'TXT');
	$calc['cc_groups'] = cot_import('cc_groups', 'P', 'ARR');
	$calc['cc_order'] = cot_import('cc_order', 'P', 'INT');

	cot_check(empty($calc['cc_name']), $L['cc_err_empty_name']);


	if (!cot_error_found())
	{
		$calc['cc_groups'] = implode(',',$calc['cc_groups']);
		cot_cc_add_calc($calc);
		cot_message($L['Added'], 'ok');
		// Return to the main page and show messages
		cot_redirect(cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc', '', true));
	}
	
}
//save changes
if($a == 'update'){
	// form handler
	$calc['cc_name'] = cot_import('cc_name', 'P', 'TXT');
	$calc['cc_desc'] = cot_import('cc_desc', 'P', 'TXT');
	$calc['cc_groups'] = cot_import('cc_groups', 'P', 'ARR');
	$calc['cc_order'] = cot_import('cc_order', 'P', 'INT');

	cot_check(empty($calc['cc_name']), $L['cc_err_empty_name']);

	if (!cot_error_found())
	{
		$calc['cc_groups'] = implode(',',$calc['cc_groups']);
		cot_cc_update_calc($id, $calc);
		cot_message($L['Updated'], 'ok');
		// Return to the main page and show messages
		cot_redirect(cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc&id='.$id, '', true));
	}
}

// load info for edit calc
if(!empty($id)){
 $calc = $db->query("SELECT * FROM $db_cc_calcs WHERE cc_id=".(int)$id)->fetch();
 $calc['cc_groups'] = explode(',', $calc['cc_groups']);
}

$tt = new XTemplate(cot_tplfile('costcalculator.tools.addeditcalc', 'plug'));

cot_display_messages($tt);

// Display the main page

foreach ($cot_groups as $key => $value) {
	if(in_array($value['id'],array(1,2,3))){ //приховуємо не потрібні групи 
		continue;
	}
	$allowgrp[$value['id']] = $value['title'];
}
// if edit  - form
if(!empty($id)){
	$formaction = cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc&a=update&id='.$id);
}else{
	$formaction = cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc&a=add');
}
// From to add new calc
$tt->assign(array(
	'CC_FORM_ACTION' => $formaction,
	'CC_NAME'  => cot_inputbox('text', 'cc_name', $calc['cc_name'], array('size' => 56, 'maxlength' => 255, 'class' => 'input-xlarge')),
	'CC_DESC'  => cot_textarea('cc_desc', $calc['cc_desc'], 3, 56, array('class' => 'input-xlarge'), ''),
	'CC_GROUP' => cot_checklistbox($calc['cc_groups'], 'cc_groups', array_keys($allowgrp), array_values($allowgrp),'','', false),
	'CC_ORDER' => cot_inputbox('text', 'cc_order', $calc['cc_order'], array('size' => 4, 'maxlength' => 255, 'class' => 'input-xlarge'))
));

$tt->parse();
$plugin_body = $tt->text('MAIN');