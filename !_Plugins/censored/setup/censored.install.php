<?php
defined('COT_CODE') or die('Wrong URL');

global $db_projects;

// Add field if missing
if (!$db->fieldExists($db_projects, "item_censore"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_censore` int(10) DEFAULT 0");
}
?>