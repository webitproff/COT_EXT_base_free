<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=input
 * Order=1
 * [END_COT_EXT]
 */
 
/**
 * plugin r301 for Cotonti Siena
 * 
 * @package r301
 * @version 1.0.0
 * @author esclkm
 * @copyright 
 * @license BSD
 *  */
// Generated by Cotonti developer tool (littledev.ru)
defined('COT_CODE') or die('Wrong URL.');

$db_r301 = !empty($db_r301) ? $db_r301 : $db_x.'r301';

$sear_path = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
$del_path = $cfg['mainurl'].((substr($cfg['mainurl'], -1) == '/') ? '' : '/');

$rep_path = str_replace($del_path, '', $sear_path);
// удаляем старое
$db->delete($db_r301, "r301_date < ".(int)$sys['now']." AND r301_date <> 0");

$r301_go = $db->query("SELECT * FROM $db_r301 WHERE r301_from ='".$db->prep($rep_path)."' OR r301_from ='".$db->prep($sear_path)."' ORDER BY r301_date DESC LIMIT 1")->fetch();
if(!empty($r301_go['r301_to']))
{
	if($r301_go['r301_type'] == '301')
	{
		if(!mb_strstr($r301_go['r301_to'], "https://"))
		{
			$r301_go['r301_to'] = $del_path.$r301_go['r301_to'];
		}

		header("HTTP/1.1 301 Moved Permanently");
		header("Location: {$r301_go['r301_to']}");
		exit();

	}
	else
	{
		$r301_go['r301_to'] = str_replace($del_path, '', $r301_go['r301_to']);
		$_GET['rwr'] = $r301_go['r301_to'];
	}
}
