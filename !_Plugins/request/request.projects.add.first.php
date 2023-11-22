<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.first
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');
cot_block($usr['isadmin']);

require_once cot_incfile('request', 'plug');

$requestid = cot_import('requestid', 'G', 'INT');
if(empty($requestid)) $requestid = cot_import('requestid', 'P', 'INT');

if(!empty($requestid))
{
	$sql = $db->query("SELECT * FROM $db_requests WHERE request_id=".$requestid);
	cot_die($sql->rowCount() == 0);
	$request = $sql->fetch();
}