<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('timeline', 'plug');

$t->assign('TIMELINE', cot_get_timeline($urr['user_id'], 'userdetails'));

?>