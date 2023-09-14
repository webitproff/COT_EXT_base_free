<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
Order=90
[END_COT_EXT]
==================== */

/**
 * DS header notices
 * @version 2.2
 * @package DS
 * @copyright (c) Alexeev Vlad (http://cmsworks.ru/users/alexvlad)
 */

defined('COT_CODE') or die('Wrong URL.');

$temp_array['PM'] = '';

if($user_data['user_id'] > 0) {
  global $R, $L, $cfg;

  $R['pm_icon'] = '<img class="icon" src="images/icons/'.$cfg['defaulticons'].'/pm.png"  alt="'.$L['pm_sendnew'].'" />';

  $temp_array['PM'] = '<a href="'.cot_url('ds', 'm=send&to='.$user_data['user_id']).'">'.$L['pm_sendnew'].' '.$R['pm_icon'].'</a>;
}