<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('products', 'module');
require_once cot_incfile('tiuorders', 'plug');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'tiuorders', 'RWA');
cot_block($usr['auth_read']);

$m = cot_import('m','G','ALP');
$id = cot_import('id','G','INT');
$key = cot_import('key', 'G', 'TXT');

if($m == 'download'){

	if ($id > 0)
	{
		$sql = $db->query("SELECT * FROM $db_products_orders  AS o
			LEFT JOIN $db_products AS m ON m.prd_id=o.order_pid
			WHERE order_id=".$id." LIMIT 1");
	}

	if (!$id || !$sql || $sql->rowCount() == 0)
	{
		cot_die_message(404, TRUE);
	}
	$tiuorder = $sql->fetch();

	cot_block($usr['isadmin'] || $usr['id'] == $tiuorder['order_userid'] || $usr['id'] == $tiuorder['order_seller'] || !empty($key) && $usr['id'] == 0);

	if($usr['id'] == 0)
	{
		$hash = sha1($tiuorder['order_email'].'&'.$tiuorder['order_id']);
		cot_block($key == $hash);
	}
	
	$file = $cfg['plugin']['tiuorders']['filepath'].'/'.$tiuorder['prd_file'];
	
	if(file_exists($file) && ($tiuorder['order_status'] == 'paid' || $tiuorder['order_status'] == 'done') || $usr['isadmin'] || $usr['id'] == $tiuorder['order_seller']){
		tiuorders_file_download($file, $mimetype='application/octet-stream');
	}else{
		cot_block();
	}
}
