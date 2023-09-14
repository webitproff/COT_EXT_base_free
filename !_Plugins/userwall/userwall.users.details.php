<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userwall', 'plug');

$t1 = new XTemplate(cot_tplfile('userwall', 'plug'));
 
$sql = $db->query("SELECT * FROM $db_userwall WHERE item_userid=".$id)->fetchAll();

foreach ($sql as $item)
{  	
  $likes = cot_walllikes($item['item_id']);		
  
  $islikers = array();
  if($likes['count'] > 0)
  {
    foreach ($likes['users'] as $urr)
    {  			
      $islikers[] = $urr['user_id'];
      $t1->assign(cot_generate_usertags($urr, 'LIKE_USER_ROW_'));
      $t1->parse('MAIN.WALL_ROW.LIKES');
    }
  }  
  
  $t1->assign(array(
     'WALL_ID' => $item['item_id'],
     'WALL_EDITABLE' => ($usr['id'] == $item['item_userid'] || $usr['maingrp'] == 5 || $usr['maingrp'] == 6) ? 1 : 0,
     'WALL_DATE' => cot_date('d.m.Y H:i', $item['item_date']),
     'WALL_DATE_AGO' => cot_build_timeago($item['item_date']),
     'WALL_TEXT' => $item['item_text'],
     'WALL_LIKES' => $likes['count'],
     'WALL_ISLIKED' => (in_array($usr['id'], $islikers)) ? 1 : 0
  ));
     
  $t1->parse('MAIN.WALL_ROW');
}        

    
if($id == $usr['id'])
{
  $t1->parse('MAIN.WALL_ADD');
}    

cot_display_messages($t1);
    
$t1->parse('MAIN');

$t->assign('WALL', $t1->text('MAIN'));

?>