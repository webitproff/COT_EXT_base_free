<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.refuse
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['projects_offers_refuse'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_projects_offers_refuse'], array(
						'user_name' => $urr['user_name'],
            'item_title' => $item['item_title'],
            'item_url' => cot_url('projects', $urlparams, '', true)
					));
  cot_add_timeline($urr['user_id'], $item['item_id'], 'projects', 'offers_refuse', $tltext);
}