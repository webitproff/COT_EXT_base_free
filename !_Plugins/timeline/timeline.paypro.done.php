<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=paypro.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['paypro_done'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  require_once cot_incfile('users', 'module');
	$advusr = $db->query("SELECT user_name FROM $db_users WHERE user_id=" . $userid)->fetch();
          
  $tltext = cot_rc($L['timeline_paypro_done'], array(
						'user_name' => $advusr['user_name'],
            'url' => cot_url('users', 'm=details&id=' . $userid.'&u='.htmlspecialchars($advusr['user_name']))
					));
  cot_add_timeline($userid, 0, 'paypro', 'done', $tltext);
}