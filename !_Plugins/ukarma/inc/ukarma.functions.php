<?php

/**
 * ukarma plugin
 *
 * @package ukarma
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Requirements
//require_once cot_langfile('ukarma', 'plug');

// Table names
cot::$db->registerTable('ukarma');

function cot_ukarma ($userid, $area = 'users', $code = '', $onlyscore = false)
{
	global $db, $cfg, $db_ukarma, $db_users;

	if($area == 'users' && $db->fieldExists($db_users, "user_ukarma"))
	{
		$score = $db->query("SELECT user_ukarma FROM $db_users WHERE user_id=".$userid)->fetchColumn();
	}
	else
	{
		$where['ukarma_userid'] = "ukarma_userid=".$userid;

		if(!empty($area) && $area != 'users')
		{
			$where['ukarma_area'] = "ukarma_area='".$area."'";
		}

		if(!empty($code))
		{
			$where['ukarma_code'] = "ukarma_code='".$code."'";
		}

		$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

		$score = $db->query("SELECT SUM(ukarma_value) FROM $db_ukarma $where")->fetchColumn();
	}
	
	if($onlyscore) return (!empty($score)) ? $score : 0;
		
	if($score > 0)
	{
		$sign = '+';
	}
	elseif($score < 0)
	{
		$sign = '-';
	}
	
	$t = new XTemplate(cot_tplfile(array('ukarma', $area), 'plug'));
	
	$t->assign(cot_generate_usertags($userid, 'UKARMA_USER_'));

	$t->assign(array(
		'UKARMA_AREA' => $area,
		'UKARMA_CODE' => $code,
		'UKARMA_SELECTOR' => 'ukarma_'.$userid.$area.$code,
		'UKARMA_SCOREENABLED' => cot_ukarma_checkenablescore($userid, $area, $code),
		'UKARMA_SCORE' => (!empty($score)) ? $score : 0,
		'UKARMA_SCORE_ABS' => (!empty($score)) ? abs($score) : 0,
		'UKARMA_SIGN' => $sign,
	));
	
	$t->parse('MAIN');
	return $t->text('MAIN');
}

function cot_ukarma_checkenablescore ($userid, $area = '', $code = '')
{
	global $db, $cfg, $sys, $usr, $db_ukarma;
	
	if(cot_auth('plug', 'ukarma', 'W'))
	{
		if($usr['id'] == $userid) return false;
		if(!cot_auth('plug', 'ukarma', 'A') && $cfg['plugin']['ukarma']['karma_rate'] > 0 && cot_ukarma($usr['id'], '', '', true) < $cfg['plugin']['ukarma']['karma_rate']) return false; 

		$where['ukarma_ownerid'] = "ukarma_ownerid=".$usr['id'];
		$where['ukarma_userid'] = "ukarma_userid=".$userid;

		if(!empty($area))
		{
			$where['ukarma_area'] = "ukarma_area='".$area."'";
		}

		if(!empty($code))
		{
			$where['ukarma_code'] = "ukarma_code='".$code."'";
		}

		$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

		$score_isset = (bool)$db->query("SELECT ukarma_id FROM $db_ukarma $where")->fetch();
		$score_enabled = (!$score_isset) ? true : false;
		
		if($cfg['plugin']['ukarma']['karma_daylimit'] > 0 && !cot_auth('plug', 'ukarma', 'A'))
		{
			$lastdate = $sys['now'] - 24*60*60;
			$score_count = $db->query("SELECT COUNT(*) FROM $db_ukarma WHERE ukarma_ownerid=".$usr['id']." AND ukarma_date >".$lastdate)->fetchColumn();
			
			if($score_count >= $cfg['plugin']['ukarma']['karma_daylimit']) $score_enabled = false;
		}
		
		if($cfg['plugin']['ukarma']['karma_personaldaylimit'] > 0 && !cot_auth('plug', 'ukarma', 'A'))
		{
			$lastdate = $sys['now'] - 24*60*60;
			$score_count = $db->query("SELECT COUNT(*) FROM $db_ukarma WHERE ukarma_ownerid=".$usr['id']." AND ukarma_userid=".$userid." AND ukarma_date >".$lastdate)->fetchColumn();
			
			if($score_count >= $cfg['plugin']['ukarma']['karma_personaldaylimit']) $score_enabled = false;
		}
		
		return $score_enabled;
	}
}
