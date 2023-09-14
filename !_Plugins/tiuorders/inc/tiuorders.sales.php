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

$status = cot_import('status', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders');
cot_block($usr['id'] > 0 && $usr['auth_read']);

if($cfg['plugin']['tiuorders']['ordersperpage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['tiuorders']['ordersperpage']);
}

/* === Hook === */
$extp = cot_getextplugins('tiuorders.sales.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['products_sales_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('tiuorders', 'sales'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('tiuorders.sales.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$where['userid'] = "order_seller=" . $usr['id'];

switch($status)
{
	
	case 'paid':
		$where['order_status'] = "o.order_status='paid'";
		break;
	
	case 'done':
		$where['order_status'] = "o.order_status='done'";
		break;
	
	case 'claim':
		$where['order_status'] = "o.order_status='claim'";
		break;
	
	case 'cancel':
		$where['order_status'] = "o.order_status='cancel'";
		break;
	
	default:
		$where['order_status'] = "o.order_status!='new'";
		break;
}

$order['date'] = 'o.order_date DESC';

/* === Hook === */
foreach (cot_getextplugins('tiuorders.sales.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';
$query_limit = ($cfg['plugin']['tiuorders']['ordersperpage'] > 0) ? "LIMIT $d, ".$cfg['plugin']['tiuorders']['ordersperpage'] : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_products_orders AS o 
	LEFT JOIN $db_products AS p ON o.order_pid=p.prd_id
	" . $where . "")->fetchColumn();

$sql = $db->query("SELECT * FROM $db_products_orders AS o
	LEFT JOIN $db_products AS p ON o.order_pid=p.prd_id
	" . $where . "
	" . $order . "
	" . $query_limit . "");

$pagenav = cot_pagenav('tiuorders', 'm=sales&status=' . $status, $d, $totalitems, $cfg['plugin']['tiuorders']['ordersperpage']);
	
$t->assign(array(
	"PAGENAV_COUNT" => $totalitems,
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
));

$catpatharray[] = array(cot_url('products'), $L['Products']);
$catpatharray[] = array('', $L['tiuorders_sales_title']);

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

/* === Hook === */
$extp = cot_getextplugins('tiuorders.sales.loop');
/* ===== */

while ($tiuorder = $sql->fetch())
{
	$t->assign(cot_generate_prdtags($tiuorder, 'ORDER_ROW_PRD_'));
	
	if($tiuorder['order_userid'] > 0)
	{
		$t->assign(cot_generate_usertags($tiuorder['order_userid'], 'ORDER_ROW_CUSTOMER_'));
	}
	
	$t->assign(array(
		"ORDER_ROW_ID" => $tiuorder['order_id'],
		"ORDER_ROW_URL" => cot_url('tiuorders','m=order&id='.$tiuorder['order_id']),
		"ORDER_ROW_COUNT" => $tiuorder['order_count'],
		"ORDER_ROW_COST" => $tiuorder['order_cost'],
		"ORDER_ROW_COMMENT" => $tiuorder['order_text'],
		"ORDER_ROW_EMAIL" => $tiuorder['order_email'],
		"ORDER_ROW_PAID" => $tiuorder['order_paid'],
		"ORDER_ROW_STATUS" => $tiuorder['order_status'],
		"ORDER_ROW_WARRANTYDATE" => $tiuorder['order_paid'] + $cfg['products']['warranty']*60*60*24,
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$t->parse("MAIN.ORDER_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('tiuorders.sales.tags') as $pl)
{
	include $pl;
}
/* ===== */
