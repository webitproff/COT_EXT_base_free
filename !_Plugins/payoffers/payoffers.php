<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payments', 'module');
require_once cot_langfile('payoffers', 'plug');

$id = cot_import('id', 'G', 'INT');
	
if (!empty($id))
{
 $offer = $sql = $db->query("SELECT * FROM $db_projects_offers WHERE offer_id=" . $id . " AND offer_userid=" . $usr['id'])->fetch();
 
 $item = $sql = $db->query("SELECT * FROM $db_projects WHERE item_id=" . $offer['offer_pid'] . "")->fetch();
 if ($offer['offer_choise'] == '')
 {
   $urlparams = empty($item['item_alias']) ?
			array('c' => $item['item_cat'], 'id' => $item['item_id']) :
			array('c' => $item['item_cat'], 'al' => $item['item_alias']);
  if ($offer['offer_paid'] == 0)
  {
   if($cfg['plugin']['payoffers']['offerpaytype'] == 'fixed')
   {
		$summ = $cfg['plugin']['payoffers']['offerpaycostfixed'];
   }
   else
   {
    $summ = ($item['item_cost'] > 0) ? $cfg['plugin']['payoffers']['offerpaycostpercent']/100*$item['item_cost'] : $cfg['plugin']['payoffers']['offerpaycostfixed'];
   }
		$options['userid'] = $usr['id'];
    $options['code'] = $id;
		$options['desc'] = $L['payoffers_buy_paydesc'].'<a href="'.$cfg['mainurl'].'/'.cot_url('projects', $urlparams, '', true).'">'.$item['item_title'].'</a>'.$L['payoffers_buy_rezerv'];
		cot_payments_create_order('offer', $summ, $options);
  }
  else
  {
 	 cot_redirect(cot_url('projects', $urlparams, '', true));
  }
 }
 else
 {
 	cot_redirect(cot_url('index'));
 }
}
else
{
 cot_redirect(cot_url('index'));
}