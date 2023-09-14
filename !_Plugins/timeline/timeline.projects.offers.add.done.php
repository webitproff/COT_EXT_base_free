<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.add.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['projects_offers_add'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_projects_offers_add'], array(
						'user_name' => $usr['profile']['user_name'],
            'item_title' => $item['item_title'],
            'item_url' => cot_url('projects', $urlparams, '', true)
					));
  cot_add_timeline($usr['id'], $item['item_id'], 'projects', 'offers_add', $tltext);
}