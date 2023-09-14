<?php
defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('easypaygroup', 'plug');

// Global variables
global $db_easypaygroup, $db_x;
$db_easypaygroup = (isset($db_easypaygroup)) ? $db_easypaygroup : $db_x . 'easypaygroup';

// Global variables
function cot_cfg_easypaygroup()
{
	global $cfg;

	$epayset = str_replace("\r\n", "\n", $cfg['plugin']['easypaygroup']['codes']);
	$epayset = explode("\n", $epayset);
	$easypaygroupset = array();
	foreach ($epayset as $lineset)
	{
		$lines = explode("|", $lineset);
		$lines[0] = trim($lines[0]);
		$lines[1] = trim($lines[1]);
		$lines[2] = (int)trim($lines[2]);
		$lines[3] = (float)trim($lines[3]);

		if (!empty($lines[0]))
		{
			$easypaygroupset[$lines[0]]['group'] = $lines[0];
			$easypaygroupset[$lines[0]]['name'] = $lines[1];
			$easypaygroupset[$lines[0]]['time'] = $lines[2];
      $easypaygroupset[$lines[0]]['cost'] = $lines[3];
		}
	}
	return $easypaygroupset;
}

function cot_get_easypaygroup($group)
{
	global $db, $cfg;

	$easypaygroup_cfg = cot_cfg_easypaygroup();

	$t1 = new XTemplate(cot_tplfile(array('easypaygroup', 'link', $group), 'plug'));

	$t1->assign(array(
		'EASYPAY_BUY_URL' => cot_url('plug', 'e=easypaygroup&code='.$group),
		'EASYPAY_BUY_NAME' => $easypaygroup_cfg[$group]['name'],
		'EASYPAY_BUY_COST' => $easypaygroup_cfg[$group]['cost'],
	));

	$t1->parse('MAIN');
	return $t1->text('MAIN');
}

function cot_get_easypaygroup_pass($count = 6, $onlyint = false)
{
  $arr = ($onlyint) ? array('1','2','3','4','5','6','7','8','9','1','2','3','4','5','6','7','8','9') : array('a','b','c',
   'd','e','f','g','h','k',
   'p','s','t','u','v','x',
   'y','z','1','2','3','4',
   '5','6','7','8','9','1',
   '2','3','4','5','6','7',
   '8','9');

  $pass = "";
  for($i = 0; $i < $count; $i++)
  {
    $index = rand(0, count($arr) - 1);
    $pass .= $arr[$index];
  }

  return $pass;
}

function cot_get_easypaygroup_info($type = '')
{
	global $usr, $sys, $easypaygroup_cfg;

  $return = '';
  if($usr['id'] > 0)
  {
   if($type == 'start') {
    if($usr['profile']['user_paygroup'] > $sys['now']) $return = cot_date('d.m.Y', ($usr['profile']['user_paygroup_start']-($easypaygroup_cfg[$usr['profile']['user_maingrp']]['time']*86400)));
   }
   elseif($type == 'end') {
    if($usr['profile']['user_paygroup'] > $sys['now']) $return = cot_date('d.m.Y', $usr['profile']['user_paygroup']);
   }
   else {
    if($usr['profile']['user_paygroup'] > $sys['now']) $return = cot_declension(round(($usr['profile']['user_paygroup']-$sys['now'])/86400), 'день,дня,дней');
   }
  }

  return $return;
}

?>