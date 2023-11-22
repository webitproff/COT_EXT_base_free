<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('request', 'plug');
require_once cot_incfile('placemarks', 'plug');

$id = cot_import('id', 'G', 'INT');
$hash = cot_import('hash', 'G', 'ALP');

$sql = $db->query("SELECT * FROM $db_requests AS r 
	LEFT JOIN $db_projects AS p ON r.request_id= p.item_requestid
	LEFT JOIN $db_users AS u ON u.user_id= p.item_userid
	WHERE request_id=".$id." AND request_status IN ('offer', 'paid')");
cot_die($sql->rowCount() == 0);
$request = $sql->fetch();

cot_block(md5($id.$request['item_id']) == $hash);


if($a == 'buy')
{
	$pilots = explode(',', $request['request_pilots']);
	$performer = cot_import('performer', 'G', 'INT');
	$rpaymenttype = cot_import('rpaymenttype', 'G', 'ALP', 2);

	cot_block(in_array($performer, $pilots));

	if(!empty($rpaymenttype))
	{
		cot_setcookie('paymenttype', $rpaymenttype, time()+$cfg['cookielifetime'], $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
	}

	$pilot = $db->query("SELECT * FROM $db_projects_offers AS o 
		LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid 
		WHERE offer_pid=".$request['item_id']." AND offer_userid=".$performer)->fetch();

	$cost = $pilot['offer_cost_min']*$cfg['plugin']['request']['tax']/100;
	$summ = number_format($cost, 0, '.', '');
	$options['desc'] = 'Оплата заказа «'.$request['item_title'].'»';
	$options['code'] = $id.':'.$performer.':'.$summ;
	
	$options['redirect'] = $cfg['mainurl'].'/'.cot_url('index', 'r=request&id='.$id.'&hash='.$hash, '#request-paid', true);
	
	cot_payments_create_order('request', $summ, $options);
}

$t = new XTemplate(cot_tplfile('request.offer', 'plug', false));

// Получаем координаты объекта съемки

$objectplacemark = $db->query("SELECT * FROM $db_placemarks
	WHERE mark_area='projects' AND mark_code='".$request['item_id']."'")->fetch();

if(empty($objectplacemark)){
	if(!empty($cot_location[$request['item_city']]['coord'][0])){
		$objectplacemark['mark_lat'] = $cot_location[$request['item_city']]['coord'][0];
		$objectplacemark['mark_lng'] = $cot_location[$request['item_city']]['coord'][1];
	}

	if(empty($objectplacemark)){
		$objectplacemark = $db->query("SELECT * FROM $db_placemarks
			WHERE mark_area='users' AND mark_code='".$request['item_userid']."'")->fetch();

		if(empty($objectplacemark) && !empty($cot_location[$request['user_city']]['coord'][0])){
			$objectplacemark['mark_lat'] = $cot_location[$request['user_city']]['coord'][0];
			$objectplacemark['mark_lng'] = $cot_location[$request['user_city']]['coord'][1];
		}
	}
}

// ==================================


$pilots = $db->query("SELECT * FROM $db_projects_offers AS o 
	LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid 
	WHERE offer_pid=".$request['item_id']." AND offer_userid IN (".$request['request_pilots'].")")->fetchAll();

foreach ($pilots as $pilot) {

	if(!empty($objectplacemark))
	{
		$distance = $db->query("SELECT (
			      6371 * acos (
			      cos ( radians(".$objectplacemark['mark_lat'].") )
			      * cos( radians( mark_lat ) )
			      * cos( radians( mark_lng ) - radians(".$objectplacemark['mark_lng'].") )
			      + sin ( radians(".$objectplacemark['mark_lat'].") )
			      * sin( radians( mark_lat ) )
			    )
			) AS distance 
			FROM $db_placemarks 
			WHERE mark_area = 'users' AND mark_code='".$pilot['offer_userid']."'")->fetchColumn();

		if(empty($distance)){
			$coord = $cot_location[$pilot['user_city']]['coord'];
			if(!empty($coord[0])){
				$distance = 6371 * acos (cos ( deg2rad($coord[0]))
					      * cos( deg2rad( $objectplacemark['mark_lat'] ))
					      * cos( deg2rad( $objectplacemark['mark_lng'] ) - deg2rad($coord[1]))
					      + sin ( deg2rad($coord[0]))
					      * sin( deg2rad( $objectplacemark['mark_lat'] ))
					    );
			}else{
				$distance = 0;
			}
		}
	}else{
		$distance = 0;
	}

	$cost = $pilot['offer_cost_min'] + $pilot['offer_cost_min']*$cfg['plugin']['request']['tax']/100;

	$t->assign(cot_generate_usertags($pilot, 'PILOT_ROW_'));
	$t->assign(array(
		'PILOT_ROW_DISTANCE' => round($distance),
		'PILOT_ROW_COMMENT' => $db->query("SELECT pilot_comment FROM $db_requests_pilots WHERE pilot_rid=".$id." AND pilot_id=".$pilot['user_id'])->fetchColumn(),
		'PILOT_ROW_COST_FULL' => number_format($cost, 0, '.', ''),
		'PILOT_ROW_COST_TAX' => number_format($pilot['offer_cost_min']*$cfg['plugin']['request']['tax']/100, 0, '.', ''),
		'PILOT_ROW_COST_PILOT' => number_format($pilot['offer_cost_min'], 0, '.', ''),
		'PILOT_ROW_BUY_URL' => cot_url('index', 'r=request&a=buy&id='.$id.'&hash='.$hash.'&performer='.$pilot['user_id']),
	));
	$t->parse('MAIN.PILOT_ROW');
}