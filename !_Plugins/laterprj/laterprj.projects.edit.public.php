<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.public
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($id > 0) {
 if($ritem['item_state'] == 0 && $ritem['item_laterprj'] > $sys['now'] && $usr['isadmin'] && $item['item_userid'] != $usr['id']) {
    $db->update($db_projects, array('item_state' => 1), 'item_id='.$id);
 } elseif($ritem['item_state'] == 0 && $ritem['item_laterprj'] > $sys['now'] && (($usr['isadmin'] && $item['item_userid'] == $usr['id']) || !$usr['isadmin'])) {
    $db->update($db_projects, array('item_laterprj' => $sys['now']), 'item_id='.$id);
 }
}