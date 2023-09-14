<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.preview.save.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($id > 0 && $prj['item_state'] == 0 && $cfg['plugin']['timeline']['market_add'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_market_add'], array(
						'user_name' => $item['user_name']
					));
  cot_add_timeline($item['item_userid'], $id, 'market', 'add', $tltext);
}