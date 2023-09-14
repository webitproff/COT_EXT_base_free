<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.admin.validate.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($item['item_id'] > 0 && $cfg['plugin']['timeline']['projects_add'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_projects_add'], array(
						'user_name' => $item['user_name']
					));
  cot_add_timeline($item['item_userid'], $id, 'projects', 'add', $tltext);
}