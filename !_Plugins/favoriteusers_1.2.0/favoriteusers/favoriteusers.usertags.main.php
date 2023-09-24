<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
Tags=users.tpl:{USERS_ROW_FAVU_STATUS}
[END_COT_EXT]
==================== */
/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */
require_once cot_incfile('favoriteusers', 'plug');
global $usr;
if($user_id != $usr['id']){
 $favu_status = (cot_favu_infavorite((int)$usr['id'],$user_id)) ? cot_rc('favu_infavu', array('text' => $L['favoriteusers_infavu'])) : '' ;
}
$temp_array['FAVU_STATUS'] = (!empty($favu_status)) ? $favu_status : '' ;