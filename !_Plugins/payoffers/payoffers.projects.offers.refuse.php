<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.refuse
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if($cfg['plugin']['payoffers']['offercancelrefund']) {
  $offer = $db->query("SELECT u.*, o.* FROM $db_projects_offers AS o
  		LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid
  		WHERE offer_pid=" . $id . " AND offer_userid=" . (int)$userid . " AND offer_paid!=0 LIMIT 1")->fetch();
    
  require_once cot_incfile('payments', 'module');

  if($offer['offer_paidsumm'] > 0)
  {
    $desc = $L['payoffers_buy_returndesc'].'<a href="'.$cfg['mainurl'].'/'.cot_url('projects', $urlparams, '', true).'">'.$item['item_title'].'</a>';
    $pdata['pay_userid'] = $urr['user_id'];
    $pdata['pay_desc'] = $desc;
	  $pdata['pay_summ'] = $offer['offer_paidsumm'];
	  $pdata['pay_area'] = 'balance';
   	$pdata['pay_status'] = 'done';
  	$pdata['pay_code'] = $offer['offer_id'];
  	$pdata['pay_cdate'] = $sys['now'];
  	$pdata['pay_pdate'] = $sys['now'];
  	$pdata['pay_adate'] = $sys['now'];
	
   	$pay_return = $db->insert($db_payments, $pdata);

		$urlparams = empty($item['item_alias']) ?
			array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			array('c' => $item['item_cat'], 'al' => $item['item_alias']);

		$rbody = cot_rc($L['payoffers_refuse_pay_body'], array(
			'offeruser_name' => $urr['user_name'],
			'prj_name' => $item['item_title'],
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
		));
      
		cot_mail($urr['user_email'], $L['payoffers_refuse_pay_header'], $rbody);
      
    $db->update($db_projects_offers,  array('offer_paidsumm' => 0), "offer_id=".(int)$offer['offer_id']);
      
    $offerscount = $db->query("SELECT COUNT(*) FROM $db_projects_offers WHERE offer_pid=" . (int)$id . " AND offer_paid!=0")->fetchColumn();
		$db->update($db_projects, array("item_offerscount" => (int)$offerscount), "item_id=" . (int)$id);
  }
}