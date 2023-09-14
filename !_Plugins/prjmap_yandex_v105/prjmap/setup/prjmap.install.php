<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');
require_once cot_incfile('folio', 'module');

global $db, $db_projects, $db_users, $db_folio;

// Add field if missing
if (!$db->fieldExists($db_projects, "item_prjmap"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_prjmap` text NOT NULL default ''");
}
if (!$db->fieldExists($db_projects, "item_prjmaplat"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_prjmaplat` FLOAT DEFAULT 0");
}
if (!$db->fieldExists($db_projects, "item_prjmaplng"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_prjmaplng` FLOAT DEFAULT 0");
}

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

// Add field if missing
if (!$db->fieldExists($db_users, "user_prjmap"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_prjmap` text NOT NULL default ''");
}
if (!$db->fieldExists($db_users, "user_prjmaplat"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_prjmaplat` FLOAT DEFAULT 0");
}
if (!$db->fieldExists($db_users, "user_prjmaplng"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_prjmaplng` FLOAT DEFAULT 0");
}

if (!$db->fieldExists($db_users, "user_mapradius"))
{
	$db->query("ALTER TABLE `$db_users` ADD COLUMN `user_mapradius` int(10) DEFAULT 0");
}
