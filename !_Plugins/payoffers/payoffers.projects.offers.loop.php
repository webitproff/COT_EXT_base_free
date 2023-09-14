<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.loop
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if($offer['offer_userid'] == $usr['id'])
{
 if ($offer['offer_choise'] != 'refuse')
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => ($offer['offer_paid']) ? '<label class="label label-success">Оплачено</label>' : '<a class="btn btn-warning btn-block" href="'.cot_url('plug', 'e=payoffers&m=buy&id='.$offer['offer_id']).'">'.$L['payoffers_buy'].'</a>',
	));
 }
 elseif ($offer['offer_paid'] && $offer['offer_choise'] != 'performer')
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => '<label class="label label-warning">Комиссия возвращена</label>',
	));
 }
 else
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => '',
	)); 
 }

 $t_o->parse("MAIN.ROWS.PAID");
}
elseif($offer['offer_id'] == $usr['id'])
{
 if ($offer['offer_choise'] == 'refuse')
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => $L['offers_otkazali'],
	));
 }
 elseif ($offer['offer_choise'] == 'performer')
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => $L['offers_vibran_ispolnitel'],
	));
 }
 else
 {
	$t_o->assign(array(
		"OFFER_ROW_PAY" => '',
	)); 
 }

 $t_o->parse("MAIN.ROWS.PAID");
}