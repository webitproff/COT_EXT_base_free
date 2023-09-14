<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.structure.first
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL');

$extension_structure[] = 'ads';
if ($n == 'ads')
{
	require_once(cot_incfile('ads', 'plug'));
	require_once cot_langfile('ads', 'plug');

	$t = new XTemplate(cot_tplfile('ads.admin.structure', 'plug'));
}
