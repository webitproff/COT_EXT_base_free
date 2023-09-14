<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');
require_once cot_incfile('payments', 'module');

global $db_users, $db_payments;

if (!$db->fieldExists($db_users, "user_paygroup"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_paygroup` int(11) default 0");
}

if (!$db->fieldExists($db_users, "user_paygroup_start"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_paygroup_start` int(11) default 0");
}

if (!$db->fieldExists($db_payments, "pay_email"))
{
	$db->query("ALTER TABLE `$db_payments` ADD COLUMN `pay_email` varchar(255) NOT NULL");
}
