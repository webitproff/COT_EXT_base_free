<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.tags
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('request', 'plug');

if($usr['isadmin'])
{
	if(!empty($requestid))
	{
		$t->assign(array(
			"PRJADD_FORM_SEND" => cot_url('projects', 'm=add&c='.$c.'&type='.$type.'&to='.$to.'&requestid='.$requestid.'&a=add'),
			"PRJADD_FORM_TITLE" => cot_inputbox('text', 'rtitle', $request['request_title'], 'size="56"'),
			"PRJADD_FORM_DEADLINE" => cot_inputbox('text', 'rdeadline', $request['request_deadline'], 'size="56"'),
		));
	}
	else
	{
		$sql = $db->query("SELECT * FROM $db_requests WHERE request_status='new'");
		while($req = $sql->fetch())
		{
			$requests[$req['request_id']] = $req['request_title'].' ('.$req['request_name'].', '.$req['request_phone'].')';
		}

		if(is_array($requests) && count($requests) > 0){
			$t->assign(array(
				"PRJADD_FORM_REQUEST" => cot_selectbox($requestid, 'requestid', array_keys($requests), array_values($requests)),
			));
		}
	}
}