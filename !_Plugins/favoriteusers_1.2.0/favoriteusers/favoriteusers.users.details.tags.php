<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags
Tags=users.details.tpl:{USERS_DETAILS_FAVORITE}
[END_COT_EXT]
==================== */
/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */
require_once cot_incfile('favoriteusers', 'plug');

if($usr['id'] != $id && $usr['id'] > 0){
	if(cot_favu_infavorite((int)$usr['id'],(int)$id)){
		$rcbtn = cot_favu_getbtn('deletefromfav',(int)$id);
	}else{
		if(!cot_favu_user_islimit((int)$usr['id'])){
			$rcbtn = cot_favu_getbtn('addtofav',(int)$id);
		}else{
			$favulimit = cot_rc('favu_limit', array('text' => $L['favoriteusers_add_limit']));
		}		
	}
	$t->assign(array(
		'USERS_DETAILS_FAVORITE' => ($favulimit) ? $favulimit : "<span id='favu_id'>".$rcbtn."</span>"
	));
}
