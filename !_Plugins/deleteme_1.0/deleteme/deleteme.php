<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

require_once cot_incfile('deleteme', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'deleteme');

cot_block($auth_read);
cot_block($usr['id']);

if($cfg['plugin']['deleteme']['dm_only_pro'] && cot_plugin_active('paypro') && !cot_getuserpro($usr['id'])){
	cot_block();
}

if($a == "send"){

	$delete = cot_import('delete', 'G', 'INT');	
	cot_block($delete);
	cot_block($usr['id'] != 1);
	if (!cot_error_found())
	{
		$options['desc'] = $L['dm_title'].' ('.$usr['name'].')';
		cot_payments_create_order('deleteme', number_format($cfg['plugin']['deleteme']['dm_cost'], 2, '.', ''), $options);
	}
}


$out['subtitle'] = $L['dm_title'];

$t = new XTemplate(cot_tplfile('deleteme', 'plug'));
cot_display_messages($t);
$t->assign(array(
		"DM_ACTION_URL" => cot_url('plug', 'e=deleteme&a=send&delete='.$usr['id']),
		"DM_COST_INFO" => $cfg['plugin']['deleteme']['dm_cost'].' '.$cfg['payments']['valuta']
	));