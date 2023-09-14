<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

global $db, $db_folio;

// Add field if missing
if (!$db->fieldExists($db_folio, "item_prjmap"))
{
	$dbres = $db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_prjmap` text NOT NULL default ''");
}
if (!$db->fieldExists($db_folio, "item_prjmaplat"))
{
	$dbres = $db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_prjmaplat` FLOAT DEFAULT 0");
}
if (!$db->fieldExists($db_folio, "item_prjmaplng"))
{
	$dbres = $db->query("ALTER TABLE `$db_folio` ADD COLUMN `item_prjmaplng` FLOAT DEFAULT 0");
}
