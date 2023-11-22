<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('request', 'plug');
require_once cot_incfile('users', 'module');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

if ($reqpays = cot_payments_getallpays('request', 'paid'))
{
	foreach ($reqpays as $pay)
	{	
		$req = explode(':', $pay['pay_code']);

		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$sql = $db->query("SELECT * FROM $db_requests AS r 
				LEFT JOIN $db_projects AS p ON r.request_id= p.item_requestid
				WHERE request_id=".(int)$req['0']);
			$request = $sql->fetch();

			if($db->update($db_requests,  array(
				'request_status' => 'paid', 
				'request_performer' => $req['1'], 
				'request_cost' => $req['2']), 
				"request_id=".(int)$req['0']))
			{
				if($db->update($db_projects_offers, array("offer_choise" => 'performer', "offer_choise_date" => (int)$sys['now_offset']), "offer_pid=" . (int)$request['item_id'] . " AND offer_userid=" . (int)$req['1'])){
					$db->update($db_projects, array("item_performer" => (int)$req['1']), "item_id=" . (int)$request['item_id']);

					if(!empty($request['request_email']))
					{
						$pilot_offer = $db->query("SELECT * FROM $db_projects_offers AS o 
							LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid
							WHERE offer_pid=" . (int)$request['item_id'] . " AND offer_userid=" . (int)$req['1'])->fetch();

						$cost_full = $pilot_offer['offer_cost_min'] + $pilot_offer['offer_cost_min']*$cfg['plugin']['request']['tax']/100;
						$cost_tax = $pilot_offer['offer_cost_min']*$cfg['plugin']['request']['tax']/100;

						$subject = $L['request_mail_buy_subject'];
						$body = cot_rc($L['request_mail_buy_body'], array(
							'zak_name' => $request['request_name'],
							'pilot_name' => $pilot_offer['user_name'],
							'pilot_url' => COT_ABSOLUTE_URL . cot_url('users', 'm=details&u='.$pilot_offer['user_name']),
							'cost_full' => number_format($cost_full, 0, '.', ''),
							'cost_tax' => number_format($cost_tax, 0, '.', ''),
							'request_title' => $request['request_title'],
							'reg_url' => COT_ABSOLUTE_URL . cot_url('users', 'm=register&usergroup=employer', '#request-paid-mail'),
							'sitename' => $cfg['maintitle']
						));

						cot_mail($request['request_email'], $subject, $body, '', false, null, true);
					}

					/* === Hook === */
					foreach (cot_getextplugins('request.buy.done') as $pl)
					{
						include $pl;
					}
					/* ===== */
				}
			}			
		}
	}
}
