<?php
defined('COT_CODE') or die('Wrong URL');

global $db_projects;

// Remove column from table
if ($db->fieldExists($db_projects, "item_censore"))
{
	$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_censore`");
}

?>