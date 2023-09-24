<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

require_once cot_incfile('payoffer', 'plug');
require_once cot_incfile('forms');

//пагінація
list($pn, $d, $d_url) = cot_import_pagenav('d', (int)$cfg['plugin']['payoffer']['po_admin_maxperpage']);

//Очистити значення ліміту
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $a == 'delete' && is_numeric($id) && $id > 0)
{
	$id = (int)$id;
	
	$resetitem = $db->query("SELECT * FROM $db_users WHERE user_payoffer > 0 AND user_id = ".$id)->fetch();
	if (!$resetitem)
	{
		cot_message($L['po_error_user'], 'error');
		cot_redirect(cot_url('admin', "m=other&p=payoffer&d=".$d, '', true));
	}
	$db->update($db_users, array('user_payoffer' => 0), "user_id =".$id);
	cot_log("Reset limit offer for user ID #" . $id, 'adm');
	cot_message('Done', 'ok');
	cot_redirect(cot_url('admin', "m=other&p=payoffer&d=".$d, '', true));

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $a == 'send')
{
	// Sample form handler
	$username = cot_import('username', 'P', 'TXT');
	$userofferlimit = cot_import('userofferlimit', 'P', 'INT');
	
	$user_id = $db->query("SELECT user_id FROM {$db_users} WHERE user_name='".$db->prep($username)."' LIMIT 1")->fetchColumn();

	cot_check(empty($user_id) || $user_id < 1, 'po_err_userfound', 'username');
	cot_check($userofferlimit < 1, 'po_err_userofferlimit', 'userofferlimit');	

	if (!cot_error_found())
	{
		$userofferleft = cot_po_getuseroffercount($user_id);
		$userofferlimit = ($userofferleft > 0) ? $userofferlimit + $userofferleft : $userofferlimit ;
		if($result = $db->update($db_users,array('user_payoffer' => $userofferlimit),"user_id=".$user_id)){
			cot_message('Added', 'ok');
		}else{
			cot_log($result, 'adm');
			cot_message($L['po_err_update'], 'error');
		}
		// Return to the main page and show messages
		cot_redirect(cot_url('admin', 'm=other&p=payoffer', '', true));
	}

	// Return to the main page and show messages
	cot_redirect(cot_url('admin', 'm=other&p=payoffer', '', true));
}

$tt = new XTemplate(cot_tplfile('payoffer.tools', 'plug'));

cot_display_messages($tt);

$sqllist = $db->query("SELECT * FROM {$db_users} WHERE user_payoffer > 0 ORDER BY user_payoffer DESC LIMIT {$d}, " . (int)$cfg['plugin']['payoffer']['po_admin_maxperpage'])->fetchAll();

// Display the main page
	foreach ($sqllist as $row) {
		$tt->assign(cot_generate_usertags($row, 'PO_ROW_'));
		$tt->assign(array(
			'PO_ROW_CONFIRM_DELETE_URL' 	=> cot_confirm_url(cot_url('admin', 'm=other&p=payoffer&a=delete&id='.$row['user_id']), 'payoffer')
		));
		$tt->parse('MAIN.ROW');	
	}

$tt->assign(array(
	'PAYOFFER_FORM_URL'    			=> cot_url('admin', 'm=other&p=payoffer'),
	'PAYOFFER_FORM_ACTION' 			=> cot_url('admin', 'm=other&p=payoffer&a=send'),
	'PAYOFFER_FORM_USERNAME'    	=> cot_inputbox('text', 'username', $username, array('size' => 15, 'maxlength' => 255, 'placeholder' => 'username', 'class' => 'userinputpayoffer')),
	'PAYOFFER_FORM_USEROFFERLIMIT'  => cot_inputbox('number', 'userofferlimit', $userofferlimit, array('size' => 5, 'maxlength' => 255, 'placeholder' => '30', 'step' => 1, 'min' => 0, 'max' => 9999999)),

));

//пагінація
$totalitems = $db->query("SELECT * FROM {$db_users} WHERE user_payoffer > 0")->rowCount();
$list_url_path['m'] = 'other';
$list_url_path['p'] = 'payoffer';
$pagenav = cot_pagenav('admin', $list_url_path, $d, $totalitems, $cfg['plugin']['payoffer']['po_admin_maxperpage']);

$tt->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" 	=> $pagenav['prev'],
	"PAGENAV_NEXT" 	=> $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems
));

$tt->parse();
$plugin_body = $tt->text('MAIN');

