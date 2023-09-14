<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.add.done
 * Order=99
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$offerscount = $db->query("SELECT COUNT(*) FROM $db_projects_offers WHERE offer_paid!=0 AND offer_pid=" . (int)$id . "")->fetchColumn();
$db->update($db_projects, array("item_offerscount" => (int)$offerscount), "item_id=" . (int)$id);
          
if($cfg['plugin']['payoffers']['offerpaytype'] == 'fixed')
{
	$summ = $cfg['plugin']['payoffers']['offerpaycostfixed'];
}
else
{
  $summ = ($item['item_cost'] > 0) ? $cfg['plugin']['payoffers']['offerpaycostpercent']/100*$item['item_cost'] : $cfg['plugin']['payoffers']['offerpaycostfixed'];
}
   
if (cot_payments_getuserbalance($usr['id']) >= $summ)
{ 
    $options['userid'] = $usr['id'];
    $options['summ'] = $summ;    
		$options['code'] = $offerid;
		$options['desc'] = $L['payoffers_buy_paydesc'].'<a href="'.$cfg['mainurl'].'/'.cot_url('projects', $urlparams, '', true).'">'.$item['item_title'].'</a>'.$L['payoffers_buy_rezerv'];
		
		if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('projects', $urlparams, '', true);
		}    

    cot_payments_create_order('offer', $summ, $options); 
}
else
{ 
	cot_message($L['payoffers_add_notpaid_done'].$summ.' '.$cfg['payments']['valuta'].' <a href="'.$cfg['mainurl'].'/'.cot_url('plug', 'e=payoffers&m=buy&id='.$offerid).'">'.$L['payoffers_buy'].'</a>', 'ok');
}
