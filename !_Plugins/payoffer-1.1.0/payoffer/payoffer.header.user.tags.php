<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
Tags=header.tpl:{HEADER_USER_PAYOFFER},{HEADER_USER_PAYOFFER_URL}
[END_COT_EXT]
==================== */

require_once cot_incfile('payoffer', 'plug');

if($offercountleft = cot_po_getuseroffercount($usr['id'])){
	$po_header_tag = cot_rc('po_user_header', array('url' => cot_url('payoffer'), 'count' => $offercountleft));
}else{
	$po_header_tag = cot_rc('po_user_header_buy', array('url' => cot_url('payoffer')));
}

$t->assign(array(
	'HEADER_USER_PAYOFFER' => $po_header_tag,
	'HEADER_USER_PAYOFFER_URL' => cot_url('payoffer'),
));