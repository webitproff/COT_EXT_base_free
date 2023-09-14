<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

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

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders', 'RWA');
cot_block($usr['isadmin']);

require_once cot_incfile('tiuorders', 'plug');
require_once cot_incfile('products', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('extrafields');

$status = cot_import('status', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders');
cot_block($usr['isadmin']);

if($cfg['plugin']['tiuorders']['ordersperpage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['tiuorders']['ordersperpage']);
}

/* === Hook === */
$extp = cot_getextplugins('tiuorders.admin.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['products_sales_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('tiuorders', 'admin'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('tiuorders.admin.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

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
foreach (cot_getextplugins('tiuorders.admin.query') as $pl)
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

$pagenav = cot_pagenav('admin', 'm=other&p=tiuorders&status=' . $status, $d, $totalitems, $cfg['plugin']['tiuorders']['ordersperpage']);
	
$t->assign(array(
	"PAGENAV_COUNT" => $totalitems,
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
));

/* === Hook === */
$extp = cot_getextplugins('tiuorders.admin.loop');
/* ===== */

while ($tiuorder = $sql->fetch())
{
	$t->assign(cot_generate_prdtags($tiuorder, 'ORDER_ROW_PRD_'));
	$t->assign(cot_generate_usertags($tiuorder['order_seller'], 'ORDER_ROW_SELLER_'));
	
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
foreach (cot_getextplugins('tiuorders.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");