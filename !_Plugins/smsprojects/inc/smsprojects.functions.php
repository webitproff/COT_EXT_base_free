<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('smsprojects', 'plug');

function smsprojects_smsru_send($phone, $text)
{
	global $cfg;

	$text = urlencode($text);
	$body = file_get_contents("http://sms.ru/sms/send?api_id=".$cfg['plugin']['smsprojects']['smsru_apiid']."&partner_id=57425&to=".$phone."&text=".$text."&test=".$cfg['plugin']['smsprojects']['smsru_test']."&translit=".$cfg['plugin']['smsprojects']['smsru_translit']."&from=".$cfg['plugin']['smsprojects']['smsru_from']);
}

function smsprojects_sendprj($prj)
{
	global $db, $cfg, $L, $db_users, $db_projects, $sys;

	if(is_numeric($prj))
	{
		$prj = $db->query("SELECT * FROM $db_projects WHERE item_id=$prj LIMIT 1")->fetch();
	}
	
	if(is_array($prj) && $prj['item_smssent'] != 1)
	{	
		$pcats = cot_structure_children('projects', $prj['item_cat']);
		if(count($pcats) == 1) $pcats = cot_structure_parents('projects', $prj['item_cat']);

		$wherecats = array();
		foreach ($pcats as $pcat) 
		{
			$wherecats[] = "FIND_IN_SET('".$db->prep($pcat)."', user_smsprojectscats)";
		}

		if(is_array($wherecats) && count($wherecats) > 0)
		{
			$where['pcats'] = "(".implode(" OR ", $wherecats).")";
		}

		$where['smsprojectscats'] = "user_smsprojectscats!=''";
		$where['phone'] = "user_phone!=''";

		if($cfg['plugin']['smsprojects']['forpro'])
		{
			$where['forpro'] = "user_pro>0";
		}

		$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

		$users_sql = $db->query("SELECT * FROM $db_users ".$where);
		while($urr = $users_sql->fetch())
		{
			$phones[] = $urr['user_phone'];	
		}

		if(is_array($phones))
		{
			$smstext = cot_rc($L['smsprojects_smstext'], array( 
				'prj_name' => $prj['item_title'],
				'sitename' => $sys['domain']
			));

			smsprojects_smsru_send(implode(',', $phones), $smstext);
		}

		$db->update($db_projects, array('item_smssent' => 1), "item_id=".$prj['item_id']);
	}
}
