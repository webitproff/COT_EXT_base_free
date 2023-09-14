<?php
/**
 * Uninstallation handler
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_products;

// Remove column from table
if ($db->fieldExists($db_users, "user_region"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_region`");
}

if ($db->fieldExists($db_users, "user_city"))
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_city`");
}


$db_products = (isset($db_products)) ? $db_products : $db_x . 'products';

if ($db->fieldExists($db_products, "prd_country"))
{
	$db->query("ALTER TABLE `$db_products` DROP COLUMN `prd_country`");
}

if ($db->fieldExists($db_products, "prd_region"))
{
	$db->query("ALTER TABLE `$db_products` DROP COLUMN `prd_region`");
}

if ($db->fieldExists($db_products, "prd_city"))
{
	$db->query("ALTER TABLE `$db_products` DROP COLUMN `prd_city`");
}
?>