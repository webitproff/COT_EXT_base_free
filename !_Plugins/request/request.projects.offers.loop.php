<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.loop
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if($usr['isadmin'] && empty($item['item_performer']) && !empty($request['request_id']))
{
	require_once cot_incfile('request', 'plug');

	if(!empty($request['request_pilots'])){
		$offeredpilots = explode(',', $request['request_pilots']);
	}

	$t_o->assign(array(
		'OFFER_ROW_OWNER_REQUEST_COMMENT' => $db->query("SELECT pilot_comment FROM $db_requests_pilots WHERE pilot_rid=".$request['request_id']." AND pilot_id=".$offer['user_id'])->fetchColumn(),
		'OFFER_ROW_OWNER_REQUEST_OFFEREDPILOT' => (is_array($offeredpilots) && in_array($offer['user_id'], $offeredpilots)) ? true : false,
	));
}