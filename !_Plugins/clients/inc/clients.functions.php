<?php

/**
 * Сlients plugin
 *
 * @package clients
 * @version 1.0
 * @author Alexeev Vlad
 */
 
defined('COT_CODE') or die('Wrong URL.');

function cot_clients_scores($userid)
{
	global $db_projects, $db;
  
	$scores = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_performer=" . (int) $userid . " ")->fetchColumn();
	return $scores;
}

function cot_clients_row($userid, $limit)
{
	global $db_projects, $db;
	
  $t1 = new XTemplate(cot_tplfile('clients', 'plug'));

	require_once cot_langfile('clients', 'plug');
		
  $limit = ($limit > 0) ? 'LIMIT '.$limit : '';
    
	$sql = $db->query("SELECT * FROM $db_projects WHERE item_performer=" . (int) $userid . " $limit");

	foreach ($sql->fetchAll() as $item)
	{
    			
		$t1->assign(cot_generate_usertags($item['item_userid'], 'CLIENTS_ROW_'));
    $t1->assign(cot_generate_projecttags($item, 'CLIENTS_ROW_PRJ_'));

		$t1->parse('MAIN.CLIENTS_ROW');
	}
    
	$t1->parse('MAIN');
	return $t1->text('MAIN');
}
?>