<?php
/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');

global $db_projects;

// Remove column from table
if ($db->fieldExists($db_projects, "item_route"))
{
	$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_route`");
}