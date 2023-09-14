<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

cot_sendheaders();

$id = (int) cot_import('id', 'G', 'INT');

if($id > 0 && $usr['id'] > 0)
{
  $isfav = $db->query("SELECT COUNT(*) FROM $db_projectfav
			WHERE fav_pid=".$id." AND fav_uid=".$usr['id'])->fetchColumn();
  
  $res = array('status' => 'success', 'text' => 'Error');

  if($isfav)
  {
    $db->delete($db_projectfav, 'fav_pid='.$id.' AND fav_uid='.$usr['id']);
    $res["text"] = $L['projectfav_star_unset_action'];
  }
  else
  {
    $db->insert($db_projectfav, array('fav_pid' => $id, 'fav_uid' => $usr['id']));
    $res["text"] = $L['projectfav_star_set_action'];
  }
  if(COT_AJAX) {
    echo json_encode($res);
  } else {
    cot_redirect(cot_url('projects', 'id='.$id, '', true));
  }
}
elseif($id > 0 && !COT_AJAX) {
  cot_redirect(cot_url('projects', 'id='.$id, '', true));
}
elseif(!COT_AJAX) {
  cot_redirect(cot_url('index', '', '', true));
}