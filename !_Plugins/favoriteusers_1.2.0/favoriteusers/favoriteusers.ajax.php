<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */
/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */
if(COT_AJAX){
	$uid = cot_import('uid', 'G', 'INT');
	$resid = cot_import('resid', 'G', 'ALP');	
	if($a == 'addtofav'){
		if(!cot_favu_user_islimit((int)$usr['id'])){
			cot_favu_add_to_fav((int)$usr['id'],(int)$uid);
			echo cot_favu_getbtn('deletefromfav', $uid, $resid);
		}else{
			echo cot_rc('favu_limit', array('text' => $L['favoriteusers_add_limit']));
		}		
	}else if($a == 'deletefromfav'){		
		cot_favu_delete_from_fav((int)$usr['id'],(int)$uid);
		echo cot_favu_getbtn('addtofav', $uid, $resid);
	}
}