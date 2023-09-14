<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if(is_array($user_data)){  
  $temp_array['STAR_1'] = $user_data['user_rquality'];
	$temp_array['STAR_2'] = $user_data['user_rcost'];
  $temp_array['STAR_3'] = $user_data['user_ramity'];
	
  $temp_array['STAR_SUMM'] = cot_get_avg_star($user_data['user_rquality'], $user_data['user_rcost'], $user_data['user_ramity']);
}