<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payprjbold.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['payprjbold_done'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  require_once cot_incfile('users', 'module');
	$advusr = $db->query("SELECT user_name FROM $db_users WHERE user_id=" . $pay['pay_userid'])->fetch();
    
  $urlparams = empty($adv['item_alias']) ?
					array('c' => $adv['item_cat'], 'id' => $adv['item_id']) :
					array('c' => $adv['item_cat'], 'al' => $adv['item_alias']);
          
  $tltext = cot_rc($L['timeline_payprjbold_done'], array(
						'user_name' => $advusr['user_name'],
            'item_title' => $adv['item_title'],
            'item_url' => cot_url('projects', $urlparams, '', true)
					));
  cot_add_timeline($pay['pay_userid'], $pay['pay_code'], 'payprjbold', 'done', $tltext);
}