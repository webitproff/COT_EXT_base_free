<?php
defined('COT_CODE') or die('Wrong URL');

cot::$db->registerTable('marketfav');

function cot_marketfav($id)
{
	global $db, $db_marketfav, $usr;
	$return = 0;

  if($id > 0 && $usr['id'] > 0)
  {
   $return = $db->query("SELECT COUNT(*) FROM $db_marketfav
			WHERE fav_pid=".$id." AND fav_uid=".$usr['id'])->fetchColumn();
	}
  return $return;
}