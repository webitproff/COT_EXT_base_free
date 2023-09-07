<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=index.tags
Tags=index.tpl: {PLUGIN_TOPANSWERS}
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'plug');
require_once cot_langfile('topanswers', 'plug');

$topa = new XTemplate(cot_tplfile("topanswers.index", 'plug'));

if ($db->fieldExists($db_com, "com_state"))
{
	$where_topanswers = ' AND c.com_state=0';
}

$topas = $db->query("SELECT * FROM $db_com as c 
	LEFT JOIN $db_users AS u ON u.user_id = c.com_authorid
	LEFT JOIN $db_pages AS p ON p.page_id = c.com_code
	WHERE c.com_rating>0 $where_topanswers ORDER BY c.com_rating DESC LIMIT ".$cfg['plugin']['topanswers']['limit'])->fetchAll();

$topa_count = count($topas);	

if($topa_count > 0){
	$jj = 1;	
	foreach($topas as $row){

		$com_text = cot_parse($row['com_text'], $cfg['plugin']['comments']['markup']);

		$topa->assign(array(
			'TOPA_ROW_ID' => $row['com_id'],
			'TOPA_ROW_URL' => cot_url($row['com_area'], 'id='.$row['com_code'].'&c='.$row['page_cat'], '#c'.$row['com_id']),
			'TOPA_ROW_AUTHOR' => cot_build_user($row['com_authorid'], htmlspecialchars($row['com_author'])),
			'TOPA_ROW_AUTHORID' => $row['com_authorid'],
			'TOPA_ROW_TEXT' => $com_text,
			'TOPA_ROW_SHORTTEXT' => cot_cutstring($com_text, $cfg['plugin']['topanswers']['cuttext']),
			'TOPA_ROW_DATE' => cot_date('datetime_medium', $row['com_date']),
			'TOPA_ROW_DATE_STAMP' => $row['com_date'],
			'TOPA_ROW_ODDEVEN' => cot_build_oddeven($jj),
			'TOPA_ROW_NUM' => $jj
		));
		
		// Extrafields
		if (isset($cot_extrafields[$db_com]))
		{
			foreach ($cot_extrafields[$db_com] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$topa->assign(array(
					'TOPA_ROW_' . $tag . '_TITLE' => isset($L['comments_' . $exfld['field_name'] . '_title']) ? $L['comments_' . $exfld['field_name'] . '_title'] : $exfld['field_description'],
					'TOPA_ROW_' . $tag => cot_build_extrafields_data('comments', $exfld, $row['com_'.$exfld['field_name']]),
				));
			}
		}

		$topa->assign(cot_generate_usertags($row, 'TOPA_ROW_AUTHOR_'), htmlspecialchars($row['com_author']));
			
		$topa->assign(array(
			'TOPA_ROW_RATING' => $row['com_rating'],
			'TOPA_ROW_DIVIDER' => ($jj < $topa_count) ? true : false
		));
		$jj++;
		
		$topa->parse('MAIN.TOPA_ROW');
	}

	$topa->parse('MAIN');

	$topa_html = $topa->text('MAIN');
	$t->assign('PLUGIN_TOPANSWERS', $topa_html);
}

?>