<?php

defined('COT_CODE') or die('Wrong URL');

global $db_projects;

require_once cot_incfile('projects', 'module');

// Add field if missing
if (!$db->fieldExists($db_projects, "item_laterprj"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_laterprj` int(11) NOT NULL DEFAULT 0");

  $laterprj = $db->query("SELECT * FROM $db_projects WHERE item_state!=1")->fetchAll();
  foreach($laterprj as $prj) {
    $db->update($db_project, array('item_laterprj' => $prj['item_date']), 'item_id='.$prj['item_id']);
  }
}


?>