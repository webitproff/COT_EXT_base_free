<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=header.user.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['payments']['balance_enabled'])
{
  require_once cot_incfile('projects', 'module');
  
  $offerspaysum = $db->query("SELECT SUM(offer_paidsumm) FROM $db_projects_offers WHERE offer_paid=1 AND offer_choise!='performer' AND offer_userid=" . (int)$usr['id'] . "")->fetchColumn();
	
  $t->assign(array(
		'HEADER_USER_OFFER_PAIDSUMM' => $offerspaysum,
	));
}
?>