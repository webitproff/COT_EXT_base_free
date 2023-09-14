<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=paytop.done
 * [END_COT_EXT]
 */

/**

  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru

**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['paytop_done'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  require_once cot_incfile('users', 'module');
	$advusr = $db->query("SELECT user_name FROM $db_users WHERE user_id=" . $pay['pay_userid'])->fetch();

  $tltext = cot_rc($L['timeline_paytop_done'], array(
						'user_name' => $advusr['user_name'],
            'url' => cot_url('users', 'm=details&id=' . $pay['pay_userid'].'&u='.htmlspecialchars($advusr['user_name']))
					));
  cot_add_timeline($pay['pay_userid'], 0, 'paytop', 'done', $tltext);
}