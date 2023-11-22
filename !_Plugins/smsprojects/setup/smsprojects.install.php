<?php

defined('COT_CODE') or die('Wrong URL');

global $db_projects, $db_users;

if (!$db->fieldExists($db_projects, "item_smssent"))
{
	$db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_smssent` tinyint(2) NOT NULL");
}

if (!$db->fieldExists($db_users, "user_smsprojectscats"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_smsprojectscats` MEDIUMTEXT collate utf8_unicode_ci NOT NULL");
}

if (!$db->fieldExists($db_users, "user_phone"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_phone` varchar(255) collate utf8_unicode_ci NOT NULL default ''");
}