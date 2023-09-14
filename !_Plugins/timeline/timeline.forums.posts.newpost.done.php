<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=forums.posts.newpost.done
 * [END_COT_EXT]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;
if ($cfg['plugin']['timeline']['forums_newforumpost'] != 'none')
{
  require_once cot_incfile('timeline', 'plug');
  $tltext = cot_rc($L['timeline_forums_newforumpost'], array(
						'user_name' => $usr['profile']['user_name'],
            'topic' => $rtopic['ft_title'],
            'post_url' => cot_url('forums', "m=posts&q=$q&n=last", '#bottom', true)
					));
  cot_add_timeline($usr['id'], 0, 'forums', 'newforumpost', $tltext);
}