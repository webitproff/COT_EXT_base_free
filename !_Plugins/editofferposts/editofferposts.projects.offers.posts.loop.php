<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.offers.posts.loop
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if (($cfg['plugin']['editofferposts']['editusers'] && $posts['post_userid'] == $usr['id']) || $usr['maingrp'] == 5)
{
  $t_s = new XTemplate(cot_tplfile('editofferposts', 'plug'));
  $t_s->assign(array(
  	"POST_ID" => $posts['post_id'],
	));
  $t_s->parse("MAIN");
  $t_o->assign(array(
  	"POST_ROW_EDIT_ON" => 1,
		"POST_ROW_EDIT_TEXT" => ' class="editableoffers_post_'.$posts['post_id'].'" style="cursor:pointer"',
    "POST_ROW_OFFEREDIT_SCRIPT" => $t_s->text("MAIN"),
	));
}
else
{
  $t_o->assign(array(
		"POST_ROW_EDIT_ON" => 0,
	));
} 
