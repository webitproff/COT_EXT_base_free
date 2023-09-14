<?php

/**
 * Dialog System
 * @version 2.2
 * @package DS
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('ds', 'a');
cot_block($usr['auth_write']);

$to = cot_import('to', 'G', 'INT');
$a = cot_import('a','G','TXT');

/* === Hook === */
foreach (cot_getextplugins('ds.send.first') as $pl)
{
	include $pl;
}
/* ===== */

if (!empty($to))
{
  if ($to != $usr['id'])
  {
   $touser = $db->query("SELECT * FROM $db_users WHERE user_id = $to LIMIT 1");  
   if ($touser->rowCount()!=0)
   {
    $touser = $touser->fetch();
    $chatid = cot_chat_id((int)$usr['id'],$to);
   }
   else
   {
    cot_die(); 
   }
  }
  else
  {
   cot_redirect(cot_url('ds'));
  }
}

if ($a == 'send')
{
	$newpmtext = cot_import('newpmtext', 'P', 'HTM');

	if (mb_strlen($newpmtext) < 2)
	{
		cot_error('ds_bodytooshort', 'newpmtext');
	}
	/* === Hook === */
	foreach (cot_getextplugins('ds.send.send.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

 if (!cot_error_found())
	{
    if (!empty($chatid)) {
    $pm['dialog'] = (int)$chatid;
    }
    else
    {
    $chatid = cot_create_chat((int)$usr['id'],$to);
	 	$pm['dialog'] = (int)$chatid;
    }
    $pm['date'] = (int)$sys['now'];
		$pm['text'] = $newpmtext; 
    $pm['touser'] = $to;
    $pmsql = $db->insert($db_ds_msg, $pm);

    $fornewpm = $db->query("SELECT * FROM $db_ds_dialog WHERE id = $chatid LIMIT 1")->fetch();
    $state = ($fornewpm['fromid'] == $usr['id']) ? array('tostatus' => '1') : array('fromstatus' => '1');
    $state = $state + array('lastmsg' => (int)$sys['now']);
    $pmsql = $db->update($db_ds_dialog, $state, "id = ".(int)$chatid."");

		/* === Hook === */
		foreach (cot_getextplugins('ds.send.send.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
    cot_redirect(cot_url('ds'));
	}
}

$title_params = array(
	'DS' => $L['Private_Messages'],
	'SEND_NEW' => $L['ds_sendnew']
);
$out['subtitle'] = cot_title('{SEND_NEW} - {DS}', $title_params);
$out['head'] .= $R['code_noindex'];

/* === Hook === */
foreach (cot_getextplugins('ds.send.main') as $pl)
{
	include $pl;
}
/* ===== */
   
require_once $cfg['system_dir'] . '/header.php';
$t = new XTemplate(cot_tplfile(array('ds', 'send')));

cot_display_messages($t);

$title[] = array(cot_url('ds'), $L['Private_Messages']);
$title[] = $L['dssend_title'];

$t->assign(array(
	'DSSEND_TITLE' => cot_breadcrumbs($title, $cfg['homebreadcrumb']),
	'DSSEND_FORM_SEND' => cot_url('ds', 'm=send&a=send&to='.$to),
	'DSSEND_FORM_TEXT' => cot_textarea('newpmtext', $newpmtext, 8, 56, '', 'input_textarea_editor') . $text_editor_code,
));

$t->assign(cot_generate_usertags($touser, 'DSSEND_TOUSER_'));

/* === Hook === */
foreach (cot_getextplugins('ds.send.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';
