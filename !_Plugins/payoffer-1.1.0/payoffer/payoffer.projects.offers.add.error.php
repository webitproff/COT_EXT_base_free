<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.add.error
[END_COT_EXT]
==================== */

if((int)$cfg['plugin']['payoffer']['po_offerslimit'] == 0 || ((int)$cfg['plugin']['payoffer']['po_offerslimit'] > 0 && ((int)$cfg['plugin']['payoffer']['po_offerslimit'] - cot_getcountoffersofuser($usr['id'])) == 0)){
	cot_check(cot_po_getuseroffercount($usr['id']) < 1, cot_rc($L['po_error_limit_empty'] , array('url' => cot_url('payoffer'))));
}