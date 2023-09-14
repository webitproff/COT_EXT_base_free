<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.add.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg;
if (!cot_error_found() && $cfg['plugin']['timeline']['users_register'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_users_register'], array(
						'user_name' => $ruser['user_name'],
            'url' => cot_url('users', 'm=details&id=' . $userid.'&u='.htmlspecialchars($ruser['user_name']))
					));
  cot_add_timeline($userid, 0, 'users', 'register', $tltext);
}