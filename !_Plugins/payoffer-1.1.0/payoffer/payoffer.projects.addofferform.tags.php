<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.addofferform.tags
Tags=projects.offers.tpl:{OFFER_FORM_PO_INFO},{OFFER_FORM_PO_BUY_URL},{OFFER_FORM_PO_URL},{OFFER_FORM_PO_COUNT_LEFT}
[END_COT_EXT]
==================== */
if((int)$cfg['plugin']['payoffer']['po_offerslimit'] > 0){
	$offercountleft = (cot_getcountoffersofuser($usr['id']) > 0) ? (int)$cfg['plugin']['payoffer']['po_offerslimit'] - cot_getcountoffersofuser($usr['id']) : (int)$cfg['plugin']['payoffer']['po_offerslimit'] ;
	$offercountleft += cot_po_getuseroffercount($usr['id']);
}else{
	$offercountleft = cot_po_getuseroffercount($usr['id']);
}

$t_o->assign(array(
	"OFFER_FORM_PO_INFO" => cot_rc($L['po_form_countleft'], array('countleft' => $offercountleft)),
	"OFFER_FORM_PO_COUNT_LEFT" => $offercountleft,
	"OFFER_FORM_PO_BUY_URL" => cot_rc('notices_link', array('url' => cot_url('payoffer'),'title'=>$L['po_user_offercount'])),
	"OFFER_FORM_PO_URL" => cot_url('payoffer')
));