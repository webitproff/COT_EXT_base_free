<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if(!empty($item['item_requestid']))
{
	require_once cot_incfile('request', 'plug');

	$sql = $db->query("SELECT * FROM $db_requests WHERE request_id=".$item['item_requestid']);
	cot_die($sql->rowCount() == 0);
	$request = $sql->fetch();
}