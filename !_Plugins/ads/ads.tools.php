<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=tools
  [END_COT_EXT]
  ==================== */


(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');


list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'ads');
cot_block($usr['isadmin']);

require_once(cot_incfile('ads', 'plug'));
require_once cot_langfile('ads', 'plug');

if ($n != 'track')
{
	$n = 'main';
}

if(empty($a))
{
	$a = 'index';
}

if (file_exists(cot_incfile('ads', 'plug', 'admin.'.$n.'.'.$a)))
{
	$t = new XTemplate(cot_tplfile('ads.admin.'.$n.'.'.$a, 'plug'));
	require_once cot_incfile('ads', 'plug', 'admin.'.$n.'.'.$a);
	$t->parse('MAIN');
	$adminmain = $t->text('MAIN');
}
else
{
	cot_die_message(404);
	exit;
}