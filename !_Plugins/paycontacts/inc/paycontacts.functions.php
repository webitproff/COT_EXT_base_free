<?php
defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('paycontacts', 'plug');

function cot_getpaycontacts($user = '')
{
	global $db, $db_users, $sys, $usr, $cfg, $L;

	if($usr['id'] > 0)
	{
		$upay = $usr['profile']['user_paycontacts'];
		$userid = $usr['id'];
	}
  else
  {
    $upay = 0;
    $userid = 0;
  }	
	
  $urr = array();
  if(!empty($user) && !is_array($user))
	{
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$user)->fetch();
	}
	elseif(is_array($user) && $user['user_id'] > 0)
	{	
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$user['user_id'])->fetch();
	}    
	
  $fields = explode(",", $cfg['plugin']['paycontacts']['extra']);
  $return = "";
	if($upay > $sys['now'] && $urr['user_paycontacts'] > $sys['now'])
	{
    $return = array();
    foreach($fields as $field)
    {
		  $return[] = $urr['user_'.$field];
	  }
    
    $return = implode("<br>", $return);
  }	
	elseif($urr['user_paycontacts'] > $sys['now'])
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = $L['paypaycontacts_buy_tag'];
  }	
	else
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = $L['paypaycontacts_buy_user_tag'];
	}
	return $return;
}

function cot_getpaycontactspm($user = '', $pm = "")
{
	global $db, $db_users, $sys, $usr, $cfg, $L;

	if($usr['id'] > 0)
	{
		$upay = $usr['profile']['user_paycontacts'];
		$userid = $usr['id'];
	}
  else
  {
    $upay = 0;
    $userid = 0;
  }	
	
  $urr = array();
  if(!empty($user) && !is_array($user))
	{
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$user)->fetch();
	}
	elseif(is_array($user) && $user['user_id'] > 0)
	{	
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$user['user_id'])->fetch();
	}    
	
  $return = "";
	if($upay > $sys['now'] && $urr['user_paycontacts'] > $sys['now'])
	{
    $return = $pm;
  }	
	elseif($urr['user_paycontacts'] > $sys['now'])
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = $L['paypaycontacts_buy_tag'];
  }	
	else
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = $L['paypaycontacts_buy_user_tag'];
	}
	return $return;
}


function cot_getpaycontactspm_send($id = '')
{
	global $db, $db_users, $sys, $usr, $cfg, $L;

	if($usr['id'] > 0)
	{
		$upay = $usr['profile']['user_paycontacts'];
		$userid = $usr['id'];
	}
  else
  {
    $upay = 0;
    $userid = 0;
  }	
	
  $urr = array();
  if($id > 0)
	{
		$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$id)->fetch();
	}    
	
  $return = false;
	if($upay > $sys['now'] && $urr['user_paycontacts'] > $sys['now'])
	{
    $return = true;
  }	
	elseif($urr['user_paycontacts'] > $sys['now'])
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = false;
  }	
	else
	{
    if($upay > 0 && $userid > 0)
    {
		  $db->update($db_users, array('user_paycontacts' => 0), "user_id=".$userid);     
    }
    $return = false;
	}
	return $return;
}

?>