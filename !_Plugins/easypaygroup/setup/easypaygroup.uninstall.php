<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');

global $db_users;

if ($db->fieldExists($db_users, "user_paygroup"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_paygroup`");
}
