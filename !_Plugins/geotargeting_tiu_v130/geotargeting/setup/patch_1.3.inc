<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

global $db_market, $cfg;

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

?>
