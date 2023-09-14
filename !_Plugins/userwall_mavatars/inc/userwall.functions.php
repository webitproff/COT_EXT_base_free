<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

// Table names
cot::$db->registerTable('userwall');
cot::$db->registerTable('userwall_likes');

function cot_walllikes($id)
{
	global $db, $db_userwall_likes, $db_users;
	$return = array('users' => array(), 'count' => 0);

  if($id > 0)
  {
   $return['count'] = $db->query("SELECT COUNT(*) FROM $db_userwall_likes
			WHERE like_pid=".$id)->fetchColumn();
   
   if($return['count'] > 0)
   {   
    $return['users'] = $db->query("SELECT u.* FROM $db_users as u LEFT JOIN $db_userwall_likes as w
			on u.user_id=w.like_uid WHERE like_pid=".$id." LIMIT 5")->fetchAll();
   }
	}
  return $return;
}

function cot_walllikes_count($id)
{
	global $db, $db_userwall_likes, $db_userwall;
	$return = 0;

  if($id > 0)
  {
   $idsql = $db->query("SELECT item_id FROM $db_userwall
			WHERE item_userid=".$id)->fetchAll();
   
   $ids = array();
   foreach($idsql as $id)
   {
     $ids[] = $id['item_id'];
   }   
   if(count($ids) > 0)
   {
    $return = $db->query("SELECT COUNT(*) FROM $db_userwall_likes
			WHERE like_pid=".implode(' OR like_pid=', $ids))->fetchColumn();
   }
	}
  return $return;
}