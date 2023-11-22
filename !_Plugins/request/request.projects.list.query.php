<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.query
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

// Скрываем все заказы, по которым были сформированы предложения для заказчика

$join_condition .= "LEFT JOIN $db_requests AS r ON r.request_id=p.item_requestid ";

$where['onlynewrequests'] = "(r.request_status='public' OR p.item_requestid=0)";