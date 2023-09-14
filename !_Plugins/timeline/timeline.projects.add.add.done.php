<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.add.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg;
if ($id > 0 && $ritem['item_state'] == 0 && $cfg['plugin']['timeline']['projects_add'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  global $usr;
  $tltext = cot_rc($L['timeline_projects_add'], array(
						'user_name' => $usr['profile']['user_name']
					));
  cot_add_timeline($usr['id'], $id, 'projects', 'add', $tltext);
}