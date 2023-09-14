<?php

defined('COT_CODE') or die('Wrong URL');

if(cot_module_active('projects')) {
  require_once cot_incfile('projects', 'module');

  global $db_projects;

  // Remove column from table
  if ($db->fieldExists($db_projects, "item_multicat"))
  {
  	//$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_multicat`");
  }
}

if(cot_module_active('uslugi')) {
  require_once cot_incfile('uslugi', 'module');

  global $db_uslugi;

  // Remove column from table
  if ($db->fieldExists($db_uslugi, "item_multicat"))
  {
  	//$db->query("ALTER TABLE `$db_uslugi` DROP COLUMN `item_multicat`");
  }
}

if(cot_module_active('market')) {
  require_once cot_incfile('market', 'module');

  global $db_market;

  // Remove column from table
  if ($db->fieldExists($db_market, "item_multicat"))
  {
  	//$db->query("ALTER TABLE `$db_market` DROP COLUMN `item_multicat`");
  }
}

if(cot_module_active('folio')) {
  require_once cot_incfile('folio', 'module');

  global $db_folio;

  // Remove column from table
  if ($db->fieldExists($db_folio, "item_multicat"))
  {
  	//$db->query("ALTER TABLE `$db_folio` DROP COLUMN `item_multicat`");
  }
}

?>