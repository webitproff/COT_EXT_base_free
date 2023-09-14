<?php
/**
 * Installation handler
 *
 * @package paycontacts
 * @version 1.0.0
 * @author Alexeev Vlad
 * @copyright Copyright (c) cotontidev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Add field if missing
if (!$db->fieldExists($db_users, "user_paycontacts"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_paycontacts` int(11) NOT NULL DEFAULT 0");
}

// Add field if missing
if (!$db->fieldExists($db_users, "user_paycontacts_sended"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_paycontacts_sended` int(11) NOT NULL DEFAULT 0");
}


?>