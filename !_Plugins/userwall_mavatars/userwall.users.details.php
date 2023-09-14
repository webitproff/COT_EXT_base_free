<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userwall', 'plug');

$t1 = new XTemplate(cot_tplfile('userwall', 'plug'));

$sql = $db->query("SELECT * FROM $db_userwall WHERE item_userid=".$id." ORDER BY item_date DESC")->fetchAll();

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

  if (cot_plugin_active('mavatars'))
  {
  	require_once cot_incfile('mavatars', 'plug');

  	$mavatar = new mavatar('userwall', $item['item_userid'], $item['item_id'], '', $mav_rowset_list);
  	$mavatars_tags = $mavatar->tags();

    $mavatars_data = array();
    $mavatars_data['MAVATAR'] = array(
                                    'IMG' => array(),
                                    'FILES' => array()
                                  );

    $mavatars_data['MAVATARCOUNT'] = array(
                                    'ALL' => 0,
                                    'IMG' => 0,
                                    'FILES' => 0
                                  );
    foreach($mavatars_tags as $mavtg) {
      if(in_array($mavtg['FILEEXT'], array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
       $mavatars_data['MAVATAR']['IMG'][] = $mavtg;
       $mavatars_data['MAVATARCOUNT']['IMG']++;
      }
      else {
       $mavatars_data['MAVATAR']['FILES'][] = $mavtg;
       $mavatars_data['MAVATARCOUNT']['FILES']++;
      }
      $mavatars_data['MAVATARCOUNT']['ALL']++;
    }

    $t1->assign(array(
       'WALL_MAVATAR' => $mavatars_data['MAVATAR'],
       'WALL_MAVATARCOUNT' => $mavatars_data['MAVATARCOUNT']
    ));
  }

  $t1->parse('MAIN.WALL_ROW');
}


if($id == $usr['id'])
{
  if (cot_plugin_active('mavatars'))
  {
  	require_once cot_incfile('mavatars', 'plug');

  	$mavatar = new mavatar('userwall', $usr['id'], '', 'edit');

  	$t1->assign('WALL_FORM_MAVATAR', $mavatar->upload_form());
  }
  $t1->parse('MAIN.WALL_ADD');
}

cot_display_messages($t1);

$t1->parse('MAIN');

$t->assign(array(
  'USERS_DETAILS_USERWALL_URL' => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=userwall'),
  'USERWALL' => $t1->text('MAIN')
));

?>
