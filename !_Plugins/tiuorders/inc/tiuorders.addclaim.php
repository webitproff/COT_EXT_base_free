<?php

/**
 * tiuorders plugin
 *
 * @package tiuorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders');
cot_block($usr['auth_read']);

if ($id > 0)
{
	$sql = $db->query("SELECT * FROM $db_products_orders  AS o
		LEFT JOIN $db_products AS p ON p.prd_id=o.order_pid
		WHERE order_id=".$id." LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$tiuorder = $sql->fetch();

cot_block($tiuorder['order_status'] == 'paid' && $tiuorder['order_userid'] == $usr['id']);

/* === Hook === */
$extp = cot_getextplugins('tiuorders.addclaim.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'add')
{
	cot_shield_protect();
	
	/* === Hook === */
	foreach (cot_getextplugins('tiuorders.addclaim.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$rorder['order_claimtext'] = cot_import('rclaimtext', 'P', 'TXT');
	
	/* === Hook === */
	foreach (cot_getextplugins('tiuorders.addclaim.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_check(empty($rorder['order_claimtext']), 'tiuorders_order_error_claimtext', 'rclaimtext');
	
	/* === Hook === */
	foreach (cot_getextplugins('tiuorders.addclaim.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		$rorder['order_claim'] = $sys['now'];
		$rorder['order_status'] = 'claim';
		
		$db->update($db_products_orders, $rorder, 'order_id='.$id);
		
		$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_seller'])->fetch();
		$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$tiuorder['order_userid'])->fetch();
			
		// Уведопляем продавца о том, что подана жалоба по этому заказу
		$rsubject = cot_rc($L['tiuorders_addclaim_mail_toseller_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
		$rbody = cot_rc($L['tiuorders_addclaim_mail_toseller_body'], array(
			'product_title' => $tiuorder['prd_title'],
			'order_id' => $tiuorder['order_id'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
		));
		cot_mail ($seller['user_email'], $rsubject, $rbody);
		
		// Уведопляем админа о том, что подана жалоба по этому заказу
		$rsubject = cot_rc($L['tiuorders_addclaim_mail_toadmin_header'], array('order_id' => $tiuorder['order_id'], 'product_title' => $tiuorder['prd_title']));
		$rbody = cot_rc($L['tiuorders_addclaim_mail_toadmin_body'], array(
			'product_title' => $tiuorder['prd_title'],
			'order_id' => $tiuorder['order_id'],	
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('tiuorders', "id=" . $tiuorder['order_id'], '', true)
		));
		cot_mail ($cfg['adminemail'], $rsubject, $rbody);

		cot_redirect(cot_url('tiuorders', 'm=order&id=' . $id, '', true));
		exit;
	}
	
	cot_redirect(cot_url('tiuorders', 'm=addclaim&id=' . $id, '', true));
	exit;
}

$out['subtitle'] = $L['tiuorders_neworder_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('tiuorders', 'addclaim', $structure['products'][$item['prd_cat']]['tpl']), 'plug');

/* === Hook === */
foreach (cot_getextplugins('tiuorders.addclaim.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$catpatharray[] = array(cot_url('products'), $L['Products']);
$catpatharray[] = array('', $L['tiuorders_addclaim_title']);

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

// Error and message handling
cot_display_messages($t);

$t->assign(array(
	"CLAIM_FORM_SEND" => cot_url('tiuorders', 'm=addclaim&id='.$id.'&a=add'),
	"CLAIM_FORM_TEXT" => cot_textarea('rclaimtext', '', 5, 60),
));

/* === Hook === */
foreach (cot_getextplugins('tiuorders.addclaim.tags') as $pl)
{
	include $pl;
}
/* ===== */
