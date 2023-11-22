<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.add.done
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

$requestid = cot_import('requestid', 'G', 'INT');
if(empty($requestid)) $requestid = cot_import('requestid', 'P', 'INT');

if(!empty($requestid) && $id)
{

	require_once cot_incfile('request', 'plug');
	
	global $db_requests;

	$db->update($db_projects, array('item_requestid' => $requestid), "item_id=".$id);
	$db->update($db_requests, array('request_status' => 'public'), "request_id=".$requestid);
}