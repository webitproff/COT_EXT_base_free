<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

// Remove column from table
if ($db->fieldExists($db_projects, "item_laterprj"))
{
	$db->query("ALTER TABLE `$db_projects` DROP COLUMN `item_laterprj`");
}


?>