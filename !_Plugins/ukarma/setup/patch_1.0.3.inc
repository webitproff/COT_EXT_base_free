<?php
/**
 * 1.0.3
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_ukarma;

// Add field if missing
if (!$db->fieldExists($db_users, "user_ukarma"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_ukarma` int(11) NOT NULL");
	
	$users = $db->query("SELECT * FROM $db_users WHERE 1")->fetchAll();
	foreach($users as $urr)
	{
		$score = $db->query("SELECT SUM(ukarma_value) FROM $db_ukarma WHERE ukarma_userid=".$urr['user_id'])->fetchColumn();
		$db->update($db_users, array('user_ukarma' => $score), "user_id=".$urr['user_id']);
	}
}
