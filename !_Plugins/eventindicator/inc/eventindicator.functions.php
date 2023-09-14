<?php
defined('COT_CODE') or die('Wrong URL');

cot::$db->registerTable('eventindicator');

function cot_eventindicator_add($item) {
	global $db, $db_eventindicator;
  $item['item_status'] = 0;
  if(!$item['item_text']) $item['item_text'] = '';

	$db->insert($db_eventindicator, $item);
}