<?php
/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');

global $db_projects;

// Add field if missing
if (!$db->fieldExists($db_projects, "item_route"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_route` text NOT NULL default ''");
}