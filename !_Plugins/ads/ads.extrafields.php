<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */


defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('ads', 'plug');
$extra_whitelist[$db_ads] = array(
	'name' => $db_ads,
	'caption' => $L['Plugin'].' Ads',
	'type' => 'plugin',
	'code' => 'ads',
	'tags' => array()
);
