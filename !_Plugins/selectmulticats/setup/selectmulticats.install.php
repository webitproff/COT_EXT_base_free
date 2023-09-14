<?php

defined('COT_CODE') or die('Wrong URL');

if(cot_module_active('projects')) {
  require_once cot_incfile('projects', 'module');

  global $db_projects;

  // Add field if missing
  if (!$db->fieldExists($db_projects, "item_multicat"))
  {
  	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_multicat` MEDIUMTEXT collate utf8_unicode_ci");
    $db->query("UPDATE $db_projects SET item_multicat=item_cat WHERE item_id>0");
  }
}

if(cot_module_active('uslugi')) {
  require_once cot_incfile('uslugi', 'module');

  global $db_uslugi;

  // Add field if missing
  if (!$db->fieldExists($db_uslugi, "item_multicat"))
  {
  	$dbres = $db->query("ALTER TABLE `$db_uslugi` ADD COLUMN `item_multicat` MEDIUMTEXT collate utf8_unicode_ci");
    $db->query("UPDATE $db_uslugi SET item_multicat=item_cat WHERE item_id>0");
  }
}

if(cot_module_active('market')) {
  require_once cot_incfile('market', 'module');

  global $db_market;

  // Add field if missing
  if (!$db->fieldExists($db_market, "item_multicat"))
  {
  	$dbres = $db->query("ALTER TABLE `$db_market` ADD COLUMN `item_multicat` MEDIUMTEXT collate utf8_unicode_ci");
    $db->query("UPDATE $db_market SET item_multicat=item_cat WHERE item_id>0");
  }
}

if(cot_module_active('folio')) {
  require_once cot_incfile('folio', 'module');

  global $db_folio;

  // Add field if missing
  if (!$db->fieldExists($db_folio, "item_multicat"))
  {
  	$dbres = $db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_multicat` MEDIUMTEXT collate utf8_unicode_ci");
    $db->query("UPDATE $db_folio SET item_multicat=item_cat WHERE item_id>0");
  }
}

?>