<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.setperformer
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
require_once cot_incfile('timeline', 'plug');

if ($cfg['plugin']['timeline']['projects_offers_setperformer'] != 'none')
{
  $tltext = cot_rc($L['timeline_projects_offers_setperformer'], array(
						'user_name' => $usr['profile']['user_name'],
            'item_title' => $item['item_title'],
            'item_url' => cot_url('projects', $urlparams, '', true)
					));
  cot_add_timeline($usr['id'], $item['item_id'], 'projects', 'offers_setperformer', $tltext);
}

if ($cfg['plugin']['timeline']['projects_offers_performer'] != 'none')
{
  $tltext = cot_rc($L['timeline_projects_offers_performer'], array(
						'user_name' => $urr['user_name'],
            'item_title' => $item['item_title'],
            'item_url' => cot_url('projects', $urlparams, '', true)
					));
  cot_add_timeline($urr['user_id'], $item['item_id'], 'projects', 'offers_performer', $tltext);
}