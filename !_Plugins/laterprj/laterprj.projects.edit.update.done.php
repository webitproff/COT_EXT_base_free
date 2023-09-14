<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.update.done
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($id > 0) {
 global $sys;
 if($ritem['item_state'] == 0 && $ritem['item_laterprj'] > $sys['now']) {
    $db->update($db_projects, array('item_state' => 1), 'item_id='.$id);
 }
}