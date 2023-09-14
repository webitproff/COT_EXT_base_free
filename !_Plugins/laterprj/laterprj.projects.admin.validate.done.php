<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.admin.validate.done
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($item['item_laterprj'] > $sys['now']) {
  $db->update($db_projects, array('item_state' => 1), 'item_id='.$id);
}