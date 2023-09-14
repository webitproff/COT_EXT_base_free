<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
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

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$out['subtitle'] = $L['ukarma_title'];
$t = new XTemplate(cot_tplfile(array('ukarma', 'statistics'), 'plug'));

$where = array();
$order = array();

$where['userid'] = "ukarma_userid=".$usr['id'];

$order['date'] = "ukarma_date DESC";

/* === Hook === */
foreach (cot_getextplugins('ukarma.statistics.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_ukarma  
	" . $where . "")->fetchColumn();

$sqllist_rowset = $db->query("SELECT * FROM $db_ukarma AS k
	LEFT JOIN $db_users AS u ON u.user_id=k.ukarma_ownerid
	" . $where . " 
	" . $order . "
	LIMIT $d, ".$cfg['maxrowsperpage'])->fetchAll();

$pagenav = cot_pagenav('ukarma', '', $d, $totalitems, $cfg['maxrowsperpage']);

$t->assign(array(
	"PAGENAV_COUNT" => $totalitems,
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
));

/* === Hook === */
$extp = cot_getextplugins('ukarma.statistics.loop');
/* ===== */

foreach ($sqllist_rowset as $score)
{
	$jj++;
	$t->assign(cot_generate_usertags($score, 'UKARMA_ROW_OWNER_'));

	if($score['ukarma_value'] > 0)
	{
		$sign = '+';
	}
	elseif($score['ukarma_value'] < 0)
	{
		$sign = '-';
	}
	
	$t->assign(array(
		'UKARMA_ROW_DATE' => $score['ukarma_date'],
		'UKARMA_ROW_AREA' => $score['ukarma_area'],
		'UKARMA_ROW_CODE' => $score['ukarma_code'],
		'UKARMA_ROW_SCORE' => (!empty($score['ukarma_value'])) ? $score['ukarma_value'] : 0,
		'UKARMA_ROW_SCORE_ABS' => (!empty($score['ukarma_value'])) ? abs($score['ukarma_value']) : 0,
		'UKARMA_ROW_SIGN' => $sign,
	));
	
	switch($score['ukarma_area'])
	{
		case 'forums' :
			require_once cot_incfile('forums', 'module');			
			$frm = $db->query("SELECT * FROM $db_forum_posts AS fp 
				LEFT JOIN $db_forum_topics AS ft ON fp.fp_topicid=ft.ft_id 
				WHERE fp.fp_id=".$score['ukarma_code'])->fetch();
			$page_url = cot_url('forums', 'm=posts&id='.$score['ukarma_code']);
			$page_title = $frm['ft_title'];
			break;
		
		case 'page' :
			require_once cot_incfile('page', 'module');
			$pag = $db->query("SELECT * FROM $db_pages WHERE page_id=".$score['ukarma_code'])->fetch();
			$page_url = cot_url('page', 'c='.$pag['page_cat'].'&id='.$score['ukarma_code']);
			$page_title = $pag['page_title'];
			break;
		
		case 'com' :
			require_once cot_incfile('comments', 'plug');	
			require_once cot_incfile('page', 'module');			
			$pag = $db->query("SELECT c.*, p.* FROM $db_com AS c LEFT JOIN $db_pages AS p ON c.com_code = p.page_id WHERE c.com_id=".$score['ukarma_code']." AND c.com_area='page'")->fetch();
			$page_url = (!empty($pag['page_alias'])) ? cot_url('page', 'c='.$pag['page_cat'].'&al='.$pag['page_alias'])."#c".$score['ukarma_code'] : cot_url('page', 'c='.$pag['page_cat'].'&id='.$pag['page_id'])."#c".$score['ukarma_code'];
			$page_title = $pag['page_title'];
			break;
	
		default :
			$page_url = cot_url('users', 'm=details&id='.$score['user_id'].'&u='.$score['user_name']);
			$page_title = $score['user_name'];
			break;
	}
	
	$t->assign(array(
		'UKARMA_ROW_URL' => $page_url,
		'UKARMA_ROW_TITLE' => $page_title,
	));
	
	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.UKARMA_ROW");
}

/* === Hook === */
foreach (cot_getextplugins('ukarma.statistics.tags') as $pl)
{
	include $pl;
}
/* ===== */