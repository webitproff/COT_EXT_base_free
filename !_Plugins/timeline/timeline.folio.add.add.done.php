<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.add.add.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($id > 0 && $ritem['item_state'] == 0 && $cfg['plugin']['timeline']['folio_add'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  global $usr;
  $tltext = cot_rc($L['timeline_folio_add'], array(
						'user_name' => $usr['profile']['user_name']
					));
  cot_add_timeline($usr['id'], $id, 'folio', 'add', $tltext);
}