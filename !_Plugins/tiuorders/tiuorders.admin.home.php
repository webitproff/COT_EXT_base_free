<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
Order=5
[END_COT_EXT]
==================== */

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

require_once cot_incfile('tiuorders', 'plug');

$tt = new XTemplate(cot_tplfile('tiuorders.admin.home', 'plug', true));

$tiuorderscount = $db->query("SELECT COUNT(*) FROM $db_products_orders WHERE 1");
$tiuorderscount = $tiuorderscount->fetchColumn();

$tiuordersclaims = $db->query("SELECT COUNT(*) FROM $db_products_orders WHERE order_status='claim'");
$tiuordersclaims = $tiuordersclaims->fetchColumn();

$tiuordersdone = $db->query("SELECT COUNT(*) FROM $db_products_orders WHERE order_status='done'");
$tiuordersdone = $tiuordersdone->fetchColumn();

$tt->assign(array(
	'ADMIN_HOME_ORDERS_URL' => cot_url('admin', 'm=other&p=tiuorders'),
	'ADMIN_HOME_ORDERS_COUNT' => $tiuorderscount,
	'ADMIN_HOME_CLAIMS_URL' => cot_url('admin', 'm=other&p=tiuorders&status=claim'),
	'ADMIN_HOME_CLAIMS_COUNT' => $tiuordersclaims,
	'ADMIN_HOME_DONE_URL' => cot_url('admin', 'm=other&p=tiuorders&status=done'),
	'ADMIN_HOME_DONE_COUNT' => $tiuordersdone,
));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
