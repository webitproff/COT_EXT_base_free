<?php

defined('COT_CODE') or die('Wrong URL.');

global $db, $db_ads, $sys, $cfg;

$id = cot_import('id', 'G', 'INT');
$ads = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$id." LIMIT 1")->fetch();
if (empty($ads))
{
	cot_die_message(404, TRUE);
}
elseif (!empty($ads['item_clickurl']))
{
  ads_tracks($id, 'click');
	header('Location: '.$ads['item_clickurl']);
}
exit();
