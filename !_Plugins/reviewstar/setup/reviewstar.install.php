<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('reviews', 'plug');

global $cot_extrafields, $db_users, $db_reviews, $db_x;
$db_reviews = (isset($db_reviews)) ? $db_reviews : $db_x . 'reviews';

// Add field if missing
if (!$db->fieldExists($db_users, "user_rquality"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_rquality` float(3) DEFAULT NULL");
}

// Add field if missing
if (!$db->fieldExists($db_reviews, "user_rquality"))
{
	$dbres = $db->query("ALTER TABLE `$db_reviews` ADD COLUMN `item_rquality` int(3) DEFAULT NULL");
}

// Add field if missing
if (!$db->fieldExists($db_users, "user_rcost"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_rcost` float(3) DEFAULT NULL");
}

// Add field if missing
if (!$db->fieldExists($db_reviews, "user_rcost"))
{
	$dbres = $db->query("ALTER TABLE `$db_reviews` ADD COLUMN `item_rcost` int(3) DEFAULT NULL");
}

// Add field if missing
if (!$db->fieldExists($db_users, "user_ramity"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_ramity` float(3) DEFAULT NULL");
}

// Add field if missing
if (!$db->fieldExists($db_reviews, "user_ramity"))
{
	$dbres = $db->query("ALTER TABLE `$db_reviews` ADD COLUMN `item_ramity` int(3) DEFAULT NULL");
}

?>