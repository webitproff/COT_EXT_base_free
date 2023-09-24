<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.first
Order=10
[END_COT_EXT]
==================== */

$a = cot_import('a', 'R', 'TXT');

if($a == 'addOrder' && cot_check_xp()){

	$setCookieData = unserialize($_COOKIE['cart']);

	cot_check(!isset($setCookieData[$id]), 'amarket_err_prdnotfound');

	// Extra fields
	if (isset($cot_extrafields[$db_amarket_orders]))
	{
		foreach ($cot_extrafields[$db_amarket_orders] as $exfld)
		{
			$ramarket['amo_'.$exfld['field_name']] = cot_import_extrafields('amo_'.$exfld['field_name'], $exfld, "P", $ramarket['amo_'.$exfld['field_name']]);
		}
	}	

	if(!cot_error_found()){

		$ramarket['amo_seller'] = $id;
		$ramarket['amo_customer'] = $usr['id'];
		$ramarket['amo_added'] = $sys['now'];
		$ramarket['amo_status'] = 1;			
		
		if($db->insert($db_amarket_orders,$ramarket)){

			$amo_id = $db->lastInsertId();
			cot_extrafield_movefiles();

			$prd_added = 0;
			foreach ($setCookieData[$id] as $prd_id => $count) {
				if($db->insert($db_amarket_products,array('amp_prd_id' => $prd_id, 'amp_prd_count' => $count, 'amo_id' => $amo_id))){
					$prd_added++;
				}
			}

			//mail notification TODO
			cot_am_notif($amo_id);
			
			unset($setCookieData[$id]);
			cot_setcookie('cart', serialize($setCookieData), $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
			cot_message($L['Added'].' '.cot_declension($prd_added, 'amarket_prds_declension'), 'ok');
		}
	}
		
	$opt_url['m'] = "details";
	$opt_url['id'] = $id;
	$opt_url['u'] = $u;
	$opt_url['tab'] = "market";
	$opt_url['d'] = $d;
	$opt_url['cat'] = cot_import('cat', 'G', 'TXT');
	cot_redirect(cot_url('users', $opt_url, '#cart', true));
}elseif (($a == 'prd_add_count' || $a == 'prd_delete_count') && cot_check_xg()) {

	$setCookieData =  unserialize($_COOKIE['cart']);
	$prd_id = cot_import('prd_id', 'G', 'INT');

	if(isset($setCookieData[$id][$prd_id])){

		switch ($a) {
			case 'prd_add_count':
				$setCookieData[$id][$prd_id]++;
				break;
			case 'prd_delete_count':
				($setCookieData[$id][$prd_id] == 1) ? '' : $setCookieData[$id][$prd_id]-- ;
				break;
			default:
				# wtf...
				break;
		}
	}

	cot_setcookie('cart', serialize($setCookieData), $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);

	$opt_url['m'] = "details";
	$opt_url['id'] = $id;
	$opt_url['u'] = $u;
	$opt_url['tab'] = "market";
	$opt_url['d'] = $d;
	$opt_url['cat'] = cot_import('cat', 'G', 'TXT');
	cot_redirect(cot_url('users', $opt_url, '#cart', true));
}