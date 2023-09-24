<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.first
Order=11
[END_COT_EXT]
==================== */

$cart = cot_import('cart', 'G', 'TXT');
$prd_id = cot_import('prd_id', 'G', 'INT');

if(in_array($cart, array('add','delete')) && $prd_id > 0 && cot_check_xg()){

	$setCookieData = unserialize($_COOKIE['cart']);

	switch ($cart) {
		case 'add':		
			if(!$setCookieData[$id][$prd_id]){
				$setCookieData[$id][$prd_id] = 1;
				cot_setcookie('cart', serialize($setCookieData), $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
				cot_message('Added', 'ok');	
			}
			break;
		case 'delete':
			if($setCookieData[$id][$prd_id]){
				unset($setCookieData[$id][$prd_id]);
				cot_setcookie('cart', serialize($setCookieData), $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
				cot_message('Deleted', 'ok');	
			}
			break;
		default:
			# wtf...
			break;
	}
	$opt_url['m'] = "details";
	$opt_url['id'] = $id;
	$opt_url['u'] = $u;
	$opt_url['tab'] = "market";
	$opt_url['d'] = $d;
	$opt_url['cat'] = cot_import('cat', 'G', 'TXT');
	cot_redirect(cot_url('users', $opt_url, '#cart', true));
}