<?php
defined('COT_CODE') or die('Wrong URL');

global $db_projects, $db_users;

if (!$db->fieldExists($db_projects, "item_adr"))
{
	$db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_adr` TEXT DEFAULT NULL");
}

if (!$db->fieldExists($db_users, "user_adr"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_adr` TEXT DEFAULT NULL");
}