<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=index.tags
Tags=index.tpl: {PLUGIN_TOPEXPERTS}
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'plug');
require_once cot_langfile('topexperts', 'plug');

$topexp = new XTemplate(cot_tplfile("topexperts.index", 'plug'));

if ($db->fieldExists($db_com, "com_state"))
{
	$where_topexperts = ' AND c.com_state=0';
}

$topexps = $db->query("SELECT u.* FROM $db_com as c
	LEFT JOIN $db_users as u ON u.user_id=c.com_authorid 
	WHERE c.com_rating>0 $where_topexperts GROUP BY com_authorid LIMIT ".$cfg['plugin']['topexperts']['limit'])->fetchAll();

$topexp_count = count($topexps);	

if($topexp_count > 0){
	$jj = 1;	
	foreach($topexps as $urr){
		$topexp->assign(cot_generate_usertags($urr, 'TOPEXP_ROW_'));
		
		$topexp->assign(array(
			'TOPEXP_ROW_DIVIDER' => ($jj < $topexp_count) ? true : false
		));
		$jj++;
		
		$topexp->parse('MAIN.TOPEXP_ROW');
	}

	$topexp->parse('MAIN');

	$topexp_html = $topexp->text('MAIN');
	$t->assign('PLUGIN_TOPEXPERTS', $topexp_html);
}

?>