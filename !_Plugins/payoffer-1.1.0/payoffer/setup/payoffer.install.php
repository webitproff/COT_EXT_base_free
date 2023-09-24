<?php defined('COT_CODE') or die('Wrong URL');

global $db, $db_users, $db_config;

if (!$db->fieldExists($db_users, "user_payoffer"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_payoffer` int(4) NOT NULL default 0");
}

$db->update($db_config,array('config_value' => 0),"config_name='offerslimit' AND config_cat='paypro'");