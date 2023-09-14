<?php
defined('COT_CODE') or die('Wrong URL');

global $db_projects, $db_users;

if ($db->fieldExists($db_projects, "item_adr"))
{
	$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_adr`");
}

if ($db->fieldExists($db_users, "user_adr"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_adr`");
}

if ($db->fieldExists($db_users, "user_mapradius"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_mapradius`");
}