<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'smsprojects');
cot_block($usr['auth_write']);

/* === Hook === */
foreach (cot_getextplugins('smsprojects.first') as $pl)
{
	include $pl;
}
/* ===== */

$allcats = cot_structure_children('projects', '', true);
$prjcats = array();
$prjcats_titles = array();
foreach($allcats as $cat)
{
	$prjcats[] = $cat;
	$prjcats_titles[] = $structure['projects'][$cat]['title'];
}

if($a == 'update')
{
	$rphone = cot_import('rphone', 'P', 'INT');
	$rcats = cot_import('cats', 'P', 'ARR');

	if(!empty($rcats)){
		$rcats = implode(',', $rcats);
	}else{
		$rcats = '';
	}

	cot_check(empty($rphone), 'smsprojects_error_phone', 'rphone');

	if(!cot_error_found())
	{
		$db->update($db_users, array('user_smsprojectscats' => $rcats, 'user_phone' => $rphone), "user_id=".$usr['id']);
	}
	cot_redirect(cot_url('smsprojects', '', '', true));
}

$out['subtitle'] = $L['smsprojects'];

$mskin = cot_tplfile(array('smsprojects'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('smsprojects.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

if(!empty($usr['profile']['user_smsprojectscats']))
{
	$rcats = explode(',', $usr['profile']['user_smsprojectscats']);
}
elseif($usr['profile']['user_smsprojectscats'] == '')
{
	$rcats = array();
}
else
{
	$rcats = $prjcats;
}

if(!empty($usr['profile']['user_phone']))
{
	$rphone = $usr['profile']['user_phone'];
}

cot_display_messages($t);

$t->assign(array(
	'SMSSENDING_ENABLED' => ($cfg['plugin']['smsprojects']['forpro'] && cot_getuserpro() || !$cfg['plugin']['smsprojects']['forpro']) ? true : false,
	'SMSPRJ_FORM_ACTION' => cot_url('smsprojects', 'a=update'),
	'SMSPRJ_FORM_PHONE' => cot_inputbox('text', 'rphone', $rphone),
	'SMSPRJ_FORM_CATS' => cot_checklistbox($rcats, 'cats', $prjcats, $prjcats_titles, '', '<br/>', false),
));

/* === Hook === */
foreach (cot_getextplugins('smsprojects.tags') as $pl)
{
	include $pl;
}
/* ===== */

?>