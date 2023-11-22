<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');
require_once cot_incfile('request', 'plug');

global $db_users, $db_projects, $db_requests;

if (!$db->fieldExists($db_projects, "item_requestid"))
{
	$db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_requestid` INT( 11 ) NOT NULL");
}

$zakazprojects = $db->query("SELECT * FROM $db_projects AS p 
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid 
	WHERE u.user_maingrp IN (5,6)")->fetchAll();

foreach($zakazprojects as $item)
{
	$rreq['request_title'] = $item['item_title'];
	$rreq['request_date'] = $item['item_date'];
	$rreq['request_status'] = 'public';

	if($db->insert($db_requests, $rreq))
	{
		$requestid = $db->lastInsertId();
		$db->update($db_projects, array('item_requestid' => $requestid), "item_id=".$item['item_id']);
	}
}