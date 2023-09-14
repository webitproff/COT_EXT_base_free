<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.offers.loop
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if (($offer['offer_userid'] == $usr['id']) || $usr['maingrp'] == 5)
{
  $t_s = new XTemplate(cot_tplfile('editoffer', 'plug'));
  $t_s->assign(array(
  	"OFFER_ID" => $offer['offer_id'],
	));
  $t_s->parse("MAIN");
  $t_o->assign(array(
  	"OFFER_ROW_EDIT_ON" => 1,
		"OFFER_ROW_EDIT_TEXT" => ' class="editableoffer_'.$offer['offer_id'].'" style="cursor:pointer" data-type="text" ',
    "OFFER_ROW_EDIT_TIME_MIN" => ' class="editableoffer_'.$offer['offer_id'].'" style="cursor:pointer" data-type="time_min" ',
    "OFFER_ROW_EDIT_TIME_MAX" => ' class="editableoffer_'.$offer['offer_id'].'" style="cursor:pointer" data-type="time_max" ',
    "OFFER_ROW_EDIT_COST" => ' class="editableoffer_'.$offer['offer_id'].'" style="cursor:pointer;width:40px;" data-type="cost" ',
    "OFFER_ROW_OFFEREDIT_SCRIPT" => $t_s->text("MAIN"),
	));
}
else
{
  $t_o->assign(array(
		"OFFER_ROW_EDIT_ON" => 0,
	));
} 
