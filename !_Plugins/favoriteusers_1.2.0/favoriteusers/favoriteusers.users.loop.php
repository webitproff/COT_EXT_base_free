<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=users.loop
Tags=users.tpl:{USERS_ROW_FAVORITE}
[END_COT_EXT]
==================== */
/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */
require_once cot_incfile('favoriteusers', 'plug');

if($usr['id'] != $urr['user_id'] && $usr['id'] > 0){
	if(cot_favu_infavorite((int)$usr['id'],(int)$urr['user_id'])){
		$rcbtn = cot_favu_getbtn('deletefromfav',(int)$urr['user_id'],'favu_'.$urr['user_id']);
	}else{
		if(!cot_favu_user_islimit((int)$usr['id'])){
			$rcbtn = cot_favu_getbtn('addtofav',(int)$urr['user_id'],'favu_'.$urr['user_id']);
		}else{
			$favulimit = cot_rc('favu_limit', array('text' => $L['favoriteusers_add_limit']));
		}		
	}
	$t->assign(array(
		'USERS_ROW_FAVORITE' => ($favulimit) ? $favulimit : "<span id='favu_".$urr['user_id']."'>".$rcbtn."</span>"
	));
}
