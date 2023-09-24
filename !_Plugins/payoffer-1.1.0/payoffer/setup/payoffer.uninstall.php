<?php defined('COT_CODE') or die('Wrong URL');

global $db, $db_users;

if ($db->fieldExists($db_users, "user_payoffer"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_payoffer`");
}