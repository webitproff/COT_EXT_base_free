<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');

global $db_users;

if (!$db->fieldExists($db_users, "user_mobile")) {
    $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_mobile` varchar(255) collate utf8_unicode_ci default ''");
}