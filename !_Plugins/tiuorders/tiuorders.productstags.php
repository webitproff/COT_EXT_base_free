<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=productstags.main
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

global $db_products_orders;

$key = cot_import('key', 'G', 'TXT');

$tiuorder = $db->query("SELECT * FROM $db_products_orders  AS o
	LEFT JOIN $db_products AS p ON p.prd_id=o.order_pid
	WHERE order_pid=".$prd_data['prd_id']." AND order_status!='new' AND order_userid=".$usr['id']." LIMIT 1")->fetch();

if(!empty($key)){
	$hash = sha1($tiuorder['order_email'].'&'.$tiuorder['order_id']);
}
if ($tiuorder && ($usr['id'] > 0 || $usr['id'] == 0 && !empty($key) && $key == $hash)){
	$temp_array['ORDER_ID'] = $tiuorder['order_id'];
	$temp_array['ORDER_URL'] = cot_url('tiuorders', 'id='.$tiuorder['order_id'].'&key='.$key);
	$temp_array['ORDER_COUNT'] = $tiuorder['order_count'];
	$temp_array['ORDER_COST'] = $tiuorder['order_cost'];
	$temp_array['ORDER_TITLE'] = $tiuorder['order_title'];
	$temp_array['ORDER_COMMENT'] = $tiuorder['order_text'];
	$temp_array['ORDER_EMAIL'] = $tiuorder['order_email'];
	$temp_array['ORDER_PAID'] = $tiuorder['order_paid'];
	$temp_array['ORDER_DONE'] = $tiuorder['order_done'];
	$temp_array['ORDER_STATUS'] = $tiuorder['order_status'];
	$temp_array['ORDER_DOWNLOAD'] = (in_array($tiuorder['order_status'], array('paid', 'done')) && !empty($tiuorder['prd_file']) && file_exists($cfg['plugin']['tiuorders']['filepath'].'/'.$tiuorder['prd_file'])) ? cot_url('plug', 'r=tiuorders&m=download&id='.$tiuorder['order_id'].'&key='.$key) : '';
	$temp_array['ORDER_LOCALSTATUS'] = $L['tiuorders_status_'.$tiuorder['order_status']];
	$temp_array['ORDER_WARRANTYDATE'] = $tiuorder['order_paid'] + $cfg['plugin']['tiuorders']['warranty']*60*60*24;
}