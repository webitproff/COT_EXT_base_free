<?php
/**
 * Uninstallation handler
 *
 * @package geotargeting
 * @version 1.2
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users, $db_products, $db_x;

// Add field if missing
if (!$db->fieldExists($db_users, "user_region"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_region` INT( 11 ) NOT NULL DEFAULT '0'");
}

if (!$db->fieldExists($db_users, "user_city"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_city` INT( 11 ) NOT NULL DEFAULT '0'");
}

if(cot_module_active('products'))
{
  $db_products = (isset($db_products)) ? $db_products : $db_x . 'products';

  if (!$db->fieldExists($db_products, "prd_country"))
  {
  	$db->query("ALTER TABLE `$db_products` ADD COLUMN `prd_country` VARCHAR( 3 ) NOT NULL DEFAULT 'ru'");
  }
  if (!$db->fieldExists($db_products, "prd_region"))
  {
  	$db->query("ALTER TABLE `$db_products` ADD COLUMN `prd_region` INT( 11 ) NOT NULL DEFAULT '0'");
  }
  if (!$db->fieldExists($db_products, "prd_city"))
  {
  	$db->query("ALTER TABLE `$db_products` ADD COLUMN `prd_city` INT( 11 ) NOT NULL DEFAULT '0'");
  }
}

if(cot_module_active('market'))
{
  $db_market = (isset($db_market)) ? $db_market : $db_x . 'market';

  if (!$db->fieldExists($db_market, "item_country"))
  {
  	$db->query("ALTER TABLE `$db_market` ADD COLUMN `item_country` VARCHAR( 3 ) NOT NULL DEFAULT 'ru'");
  }
  if (!$db->fieldExists($db_market, "item_region"))
  {
  	$db->query("ALTER TABLE `$db_market` ADD COLUMN `item_region` INT( 11 ) NOT NULL DEFAULT '0'");
  }
  if (!$db->fieldExists($db_market, "item_city"))
  {
  	$db->query("ALTER TABLE `$db_market` ADD COLUMN `item_city` INT( 11 ) NOT NULL DEFAULT '0'");
  }
}