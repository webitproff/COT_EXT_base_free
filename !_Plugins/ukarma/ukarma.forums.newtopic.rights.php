<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.newtopic.rights
[END_COT_EXT]
==================== */

/**
 * ukarma plugin
 *
 * @package ukarma
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if(!cot_auth('plug', 'ukarma', 'A') && $cfg['plugin']['ukarma']['karma_addtopic'] != 'null' && cot_ukarma($usr['id'], '', '', true) < $cfg['plugin']['ukarma']['karma_addtopic'])
{
	$usr['auth_write'] = false;
	$ukarma_disablenewtopic = true;
}