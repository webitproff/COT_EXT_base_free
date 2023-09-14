<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.add.add.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
require_once cot_incfile('timeline', 'plug');

if ($cfg['plugin']['timeline']['reviews_add'] != 'none')
{ 
  $tltext = cot_rc($L['timeline_reviews_add'], array(
						'user_name' => $usr['profile']['user_name'],
            'touser_name' => $uinfo['user_name']
					));
  cot_add_timeline($usr['id'], 0, 'reviews', 'add', $tltext);
}

if ($cfg['plugin']['timeline']['reviews_give'] != 'none')
{ 
  $tltext = cot_rc($L['timeline_reviews_give'], array(
						'user_name' => $uinfo['user_name'],
            'fromuser_name' => $usr['profile']['user_name']
					));
  cot_add_timeline($uinfo['user_id'], 0, 'reviews', 'give', $tltext);
}