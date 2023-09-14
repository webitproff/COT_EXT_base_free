<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.hide
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($id > 0) {
  $db->update($db_projects, array('item_laterprj' => 0), 'item_id='.$id);
}