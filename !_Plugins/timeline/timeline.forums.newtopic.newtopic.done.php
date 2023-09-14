<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=forums.newtopic.newtopic.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['forums_newtopic'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_forums_newtopic'], array(
						'user_name' => $usr['profile']['user_name'],
            'topic' => $rtopic['ft_title'],
            'topic_url' => cot_url('forums', "m=posts&q=$q&n=last", '#bottom')
					));
  cot_add_timeline($usr['id'], 0, 'forums', 'newtopic', $tltext);
}