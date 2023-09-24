<?php defined('COT_CODE') or die('Wrong URL');
/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */
// Requirements
require_once cot_langfile('favoriteusers', 'plug');
require_once cot_incfile('favoriteusers', 'plug', 'resources');

// Registering tables
cot::$db->registerTable('favorite_users');


function cot_favu_getbtn($action_favu,$uid,$favu_id='favu_id'){
	global $L, $R;
	if($action_favu == 'addtofav'){
		$favuurl = cot_url('index', array('r'=>'favoriteusers','uid'=> $uid, 'resid'=> ($favu_id != 'favu_id') ? $favu_id : '', 'a'=>'addtofav'));
		$rcbtn = cot_rc('favu_add_btn', array('addurl' => $favuurl, 'favu_id' => $favu_id, 'addtofav' => $L['favoriteusers_add_to_fav']));
	}else if($action_favu == 'deletefromfav'){
		$favuurl = cot_url('index', array('r'=>'favoriteusers','uid'=> $uid, 'resid'=> ($favu_id != 'favu_id') ? $favu_id : '', 'a'=>'deletefromfav'));
		$rcbtn = cot_rc('favu_delete_btn', array('deleteurl' => $favuurl, 'favu_id' => $favu_id, 'deletefromfav' => $L['favoriteusers_delete_from_fav']));
	}else{
		return false;
	}
	return $rcbtn;
}

function cot_favu_infavorite($user_id,$added_user_id){
	global $db, $db_favorite_users;
	return $db->query("SELECT COUNT(*) FROM {$db_favorite_users} WHERE favu_user_id={$user_id} AND favu_added_user_id={$added_user_id}")->fetchColumn();
}

function cot_favu_add_to_fav($user_id,$added_user_id){
	global $db, $db_favorite_users;
	if($user_id <= 0 || $added_user_id <= 0)
		return false;

	/* === Hook === */
	foreach (cot_getextplugins('favu.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$db->insert($db_favorite_users, array('favu_user_id' => $user_id,'favu_added_user_id' => $added_user_id),false,true);

	/* === Hook === */
	foreach (cot_getextplugins('favu.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */	
}
function cot_favu_delete_from_fav($user_id,$delete_user_id){
	global $db, $db_favorite_users;
	if($user_id <= 0 || $delete_user_id <= 0)
		return false;

	/* === Hook === */
	foreach (cot_getextplugins('favu.delete.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$db->delete($db_favorite_users, "favu_user_id = {$user_id} AND favu_added_user_id = {$delete_user_id} LIMIT 1");

	/* === Hook === */
	foreach (cot_getextplugins('favu.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

function cot_favu_user_islimit($user_id){
	global $db, $db_favorite_users, $cfg;

	if($user_id <= 0)
		return false;

	if(cot_plugin_active('paypro') && (int)$cfg['plugin']['favoriteusers']['favu_limitperuser'] > 0 && !cot_getuserpro($user_id)){
		return (int)$cfg['plugin']['favoriteusers']['favu_limitperuser'] <= $db->query("SELECT COUNT(*) FROM {$db_favorite_users} WHERE favu_user_id={$user_id}")->fetchColumn();
	}

	return false;
}