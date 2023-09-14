<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_langfile('payoffers', 'plug');

if ($pays = cot_payments_getallpays('offer', 'paid'))
{
	foreach ($pays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_projects_offers,  array('offer_paidsumm' => $pay['pay_summ'], 'offer_paid' => 1), "offer_id=".(int)$pay['pay_code']);
      $id = $pay['pay_code'];
      $prj = $db->query("SELECT * FROM $db_projects_offers WHERE offer_id=" . $id . "")->fetch();
      $item = $db->query("SELECT * FROM $db_projects WHERE item_id=" . (int)$prj['offer_pid'] . "")->fetch();
       
       $urlparams = empty($item['item_alias']) ?
		  	array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			  array('c' => $item['item_cat'], 'al' => $item['item_alias']);
    
      $user_name = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$item['item_userid'] . "")->fetch();
      $offeruser_name = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$pay['pay_userid'] . "")->fetch();
    
		   $rsubject = cot_rc($L['project_added_offer_header'], array('prtitle' => $item['item_title']));
		   $rbody = cot_rc($L['project_added_offer_body'], array(
			  'user_name' => $user_name['user_name'],
			  'offeruser_name' => $offeruser_name['user_name'],
			  'prj_name' => $item['item_title'],	
			  'sitename' => $cfg['maintitle'],
			  'link' => COT_ABSOLUTE_URL . cot_url('projects', $urlparams, '', true)
		  ));
		  cot_mail($user_name['user_email'], $rsubject, $rbody);

		  $offerscount = $db->query("SELECT COUNT(*) FROM $db_projects_offers WHERE offer_paid!=0 AND offer_pid=" . (int)$item['item_id'] . "")->fetchColumn();
		  $db->update($db_projects, array("item_offerscount" => (int)$offerscount), "item_id=" . (int)$item['item_id']);
      
			/* === Hook === */
			foreach (cot_getextplugins('payoffer.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}
