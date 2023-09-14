<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('marketfav', 'plug');

$id = (int) cot_import('id', 'G', 'INT');

if($id > 0 && $usr['id'] > 0 && COT_AJAX)
{
  $isfav = $db->query("SELECT COUNT(*) FROM $db_marketfav
			WHERE fav_pid=".$id." AND fav_uid=".$usr['id'])->fetchColumn();
  
  $res = array('info' => 'danger');

  if($isfav)
  {
    $db->delete($db_marketfav, 'fav_pid='.$id.' AND fav_uid='.$usr['id']);
    $res["text"] = "Товар удален из избранного";
  }
  else
  {
    $db->insert($db_marketfav, array('fav_pid' => $id, 'fav_uid' => $usr['id']));
    $res["text"] = "Товар добавлен в избранное";
  }

  print json_encode($res);
}