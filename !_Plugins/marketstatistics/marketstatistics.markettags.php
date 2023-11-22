<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=markettags.main
 * [END_COT_EXT]
 */
/**
 * marketorders plugin
 *
 * @package marketstatistics
 * @version 1.0.0
 * @author Attar
 * @copyright Copyright (c) PluginsPro.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

include_once cot_langfile("marketstatistics", "plug");

global $db_market, $db_market_orders, $m, $item_data;

$marketorder_sells = $db->query("SELECT COUNT(order_id) as sells, SUM(order_cost) as cost FROM `{$db_market_orders}` WHERE order_pid=" . $item_data['item_id'] . " AND order_status='done' LIMIT 1")->fetch();


//$t1 = new XTemplate(cot_tplfile("marketstatistics.{$m}", "plug"));

$t1->assign(array(
     "MS_SELLS" => $marketorder_sells['sells'] ? $marketorder_sells['sells'] : 0
    ,"MS_SELLS_COST" => $marketorder_sells['cost'] ? $marketorder_sells['cost'] : 0
));

$t1->parse("MAIN");
$temp_array['STATISTICS'] = $t1->text("MAIN");
