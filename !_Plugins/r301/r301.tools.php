<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */
/**
 * plugin r301 for Cotonti Siena
 * 
 * @package r301
 * @version 1.5.0
 * @author esclkm
 * @copyright 
 * @license BSD
 *  */
// Generated by Cotonti developer tool (littledev.ru)
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('r301', 'plug');

$db_r301 = !empty($db_r301) ? $db_r301 : $db_x.'r301';
require_once cot_incfile('forms');

if ($a == 'delete')
{
	cot_check_xg();
	$db->delete($db_r301, "r301_id=$id");
	cot_redirect(cot_url('admin', 'm=other&p=r301', '', true));
}
elseif ($a == 'update')
{
	$r301_from = cot_import('rfrom', 'P', 'ARR');
	$r301_to = cot_import('rto', 'P', 'ARR');
	$r301_date = cot_import('rdate', 'P', 'ARR');
	$r301_type = cot_import('rtype', 'P', 'ARR');
	$r301_regex = (int)cot_import('rregex', 'P', 'ARR');	
	
	foreach($r301_from as $key => $val)
	{
		$db_ins = array();
		$db_ins['r301_from'] = cot_import($r301_from[$key], 'D', 'TXT');
		$db_ins['r301_to'] = cot_import($r301_to[$key], 'D', 'TXT');
		$db_ins['r301_date'] = (int)cot_import_date($r301_date[$key], true, false, 'D');
		$db_ins['r301_type'] = cot_import($r301_type[$key], 'D', 'TXT');
		$db_ins['r301_regex'] = (int)cot_import($r301_regex[$key], 'D', 'BOL');
		$db->update($db_r301, $db_ins, "r301_id=$key");
	}
	cot_redirect(cot_url('admin', 'm=other&p=r301', '', true));
}
elseif ($a == 'add')
{
	$db_ins['r301_from'] = cot_import('rfrom', 'P', 'TXT');
	$db_ins['r301_to'] = cot_import('rto', 'P', 'TXT');
	$db_ins['r301_date'] = (int)cot_import_date('rdate');
	$db_ins['r301_type'] = cot_import('rtype', 'P', 'TXT');
	$db_ins['r301_regex'] = (int)cot_import('rregex', 'P', 'BOL');
	if(!empty($db_ins['r301_from']) && !empty($db_ins['r301_to']))
	{
		if ($db->query("SELECT COUNT(*) FROM $db_r301 WHERE r301_from = '".$db->prep($db_ins['r301_from'])."'")->fetchColumn() > 0)
		{
			cot_error('301_duplicate', 'rfrom');
		}
		else
		{
			$db->insert($db_r301, $db_ins);
		}
	}
	cot_redirect(cot_url('admin', 'm=other&p=r301', '', true));
}
elseif ($a == 'id2al')
{
	// Redirect IDs to aliases
	require_once cot_incfile('page', 'module');
	$res = $db->query("SELECT page_cat, page_id, page_alias FROM $db_pages WHERE page_alias != ''");
	while ($row = $res->fetch())
	{
		$src_url = cot_url('page', array('c' => $row['page_cat'], 'id' => $row['page_id']));
		$dest_url = cot_url('page', array('c' => $row['page_cat'], 'al' => $row['page_alias']));
		// Search for duplicate source
		if ($db->query("SELECT COUNT(*) FROM $db_r301 WHERE r301_from = '".$db->prep($src_url)."'")->fetchColumn() == 0)
		{
			// OK, insert
			$db->insert($db_r301, array(
				'r301_from' => $src_url,
				'r301_to' => $dest_url,
				'r301_date' => 0,
				'r301_type' => '301',
				'r301_regex' => 0
			));
		}
	}
	// Done
	cot_redirect(cot_url('admin', 'm=other&p=r301', '', true));
}

$t = new XTemplate(cot_tplfile('r301.tools', 'plug'));

$sql = $db->query("SELECT * FROM $db_r301 WHERE 1 ORDER BY r301_date DESC");
$ii = 0;
foreach ($sql->fetchAll() as $row)
{
	$ii++;
	$t->assign(array(
		'ADMIN_R301_DEL_URL' => cot_url('admin', 'm=other&p=r301&a=delete&id='.$row['r301_id'].'&'.cot_xg()),
		'ADMIN_R301_ITEM_ID' => $row['r301_id'],
		'ADMIN_R301_FROM' => cot_inputbox('text', 'rfrom['.$row['r301_id'].']', $row['r301_from'], 'style="width:98%;"'),
		'ADMIN_R301_TO' => cot_inputbox('text', 'rto['.$row['r301_id'].']', $row['r301_to'], 'style="width:98%;"'),
		'ADMIN_R301_DATE' => cot_selectbox_date((int)$row['r301_date'], 'short', 'rdate['.$row['r301_id'].']'),
		'ADMIN_R301_REGEX' => cot_checkbox($row['r301_regex'], 'rregex['.$row['r301_id'].']'),
		'ADMIN_R301_TYPE' => cot_selectbox($row['r301_type'], 'rtype['.$row['r301_id'].']', array('301', 'rewrite'), array('301', 'rewrite'), false),
		'ADMIN_R301_ODDEVEN' => cot_build_oddeven($ii)
	));

	$t->parse('MAIN.R301_ROW');
}
$t->assign('ADMIN_R301_UPDATE_URL', cot_url('admin', 'm=other&p=r301&a=update'));
if ($ii == 0)
{
	$t->parse('MAIN.R301_NOROW');
}
if ((int)$cfg['plugin']['r301']['defdates'] > 0)
{
	$utime = (int)$cfg['plugin']['r301']['defdates'] * 86400 + $sys['now'];
}
else
{
	$utime = 0;
}

$t->assign(array(
	'ADMIN_R301_ADD_URL' => cot_url('admin', 'm=other&p=r301&a=add'),
	'ADMIN_R301_FROM' => cot_inputbox('text', 'rfrom'),
	'ADMIN_R301_TO' => cot_inputbox('text', 'rto'),
	'ADMIN_R301_DATE' => cot_selectbox_date($utime, 'short', 'rdate'),
	'ADMIN_R301_REGEX' => cot_checkbox(false, 'rregex'),
	'ADMIN_R301_TYPE' => cot_selectbox('301', 'rtype', array('301', 'rewrite'), array('301', 'rewrite'), false),
	'ADMIN_R301_ID2AL_URL' => cot_url('admin', 'm=other&p=r301&a=id2al')
));

cot_display_messages($t);

$t->parse('MAIN');
if (COT_AJAX)
{
	$t->out('MAIN');
}
else
{
	$adminmain = $t->text('MAIN');
} 
