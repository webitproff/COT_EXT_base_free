<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('projectfav', 'plug');
require_once cot_incfile('projectfav', 'plug', 'resources');

cot::$db->registerTable('projectfav');

function cot_projectfav($id)
{
	global $db, $db_projectfav, $usr, $R;
	$return = 0;

  if($id > 0 && $usr['id'] > 0)
  {
   $return = $db->query("SELECT COUNT(*) FROM $db_projectfav
			WHERE fav_pid=".$id." AND fav_uid=".$usr['id'])->fetchColumn();
	}
  return cot_rc(($return > 0 ? $R['projectfav_star_off'] : $R['projectfav_star_on']), array('url' => cot_url('plug', 'r=projectfav&id='.$id), 'id' => $id));
}