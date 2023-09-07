<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=index.tags
Tags=index.tpl: {PLUGIN_TOPQUESTIONS}
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page', 'module');
require_once cot_langfile('topquestions', 'plug');

$topq = new XTemplate(cot_tplfile("topquestions.index", 'plug'));

$topqs = $db->query("SELECT * FROM $db_pages
	WHERE page_rating>0 ORDER BY page_rating DESC LIMIT ".$cfg['plugin']['topquestions']['limit'])->fetchAll();

$topq_count = count($topqs);	

if($topq_count > 0){
	$jj = 1;	
	foreach($topqs as $pag){
		$topq->assign(cot_generate_pagetags($pag, 'TOPQ_ROW_', $cfg['plugin']['topquestions']['cuttext']));
		
		$topq->assign(array(
			'TOPQ_ROW_CUTTITLE' => cot_cutstring($pag['page_title'], $cfg['plugin']['topquestions']['cuttitle']),
			'TOPQ_ROW_RATING' => $pag['page_rating'],
			'TOPQ_ROW_DIVIDER' => ($jj < $topq_count) ? true : false
		));
		$jj++;
		
		$topq->parse('MAIN.TOPQ_ROW');
	}

	$topq->parse('MAIN');

	$topq_html = $topq->text('MAIN');
	$t->assign('PLUGIN_TOPQUESTIONS', $topq_html);
}

?>