<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.add.done
[END_COT_EXT]
==================== */
$countoffernow = cot_getcountoffersofuser($usr['id']);
if((int)$cfg['plugin']['payoffer']['po_offerslimit'] > 0 && ((int)$cfg['plugin']['payoffer']['po_offerslimit'] - $countoffernow) > 0){
		cot_message(cot_rc($L['po_addoffer_freecountleft'], array('countleft' => $cfg['plugin']['payoffer']['po_offerslimit'] - $countoffernow -1)), 'ok');
}else{
	if($offercountleft = cot_po_addoffer($usr['id'])){
		cot_message(cot_rc($L['po_addoffer_countleft'], array('countleft' => $offercountleft)), 'ok');
	}else{
		cot_log('Error change limit offer for user ID'.$usr['id'], 'plg');
	}
}

