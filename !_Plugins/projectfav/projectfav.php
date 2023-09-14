<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL');

cot_block($usr['id'] > 0);

$maxrowsperpage = ($cfg['projects']['cat_' . $c]['maxrowsperpage']) ? $cfg['projects']['cat_' . $c]['maxrowsperpage'] : $cfg['projects']['cat___default']['maxrowsperpage'];
list($pn, $d, $d_url) = cot_import_pagenav('d', $maxrowsperpage);

$out['subtitle'] = $L['projectfav'];
$out['desc'] = $cfg['projects']['cat___default']['metadesc'];
$out['keywords'] = $cfg['projects']['cat___default']['keywords'];

$where = array();
$order = array();

$where['state'] = "item_state=0";
$where['owner'] = "fav_uid=" . $usr['id'];

$order['date'] = 'item_date DESC';

$list_url_path = array('e' => 'projectfav');

// Building the canonical URL
$out['canonical_uri'] = cot_url('plug', $list_url_path);

$mskin = cot_tplfile(array('projectfav'), 'plug');

$t = new XTemplate($mskin);

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projectfav as fav JOIN $db_projects AS p ON fav.fav_pid=p.item_id
  LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	" . $where . "")->fetchColumn();

$sqllist = $db->query("SELECT p.*, u.* FROM $db_projectfav as fav JOIN $db_projects AS p ON fav.fav_pid=p.item_id
	LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	" . $where . "
	" . $order . "
	LIMIT $d, " . $maxrowsperpage);

$pagenav = cot_pagenav('plug', $list_url_path, $d, $totalitems, $maxrowsperpage);

$catpath = cot_breadcrumbs(array(array(cot_url('plug', 'e=projectfav'), $L['projectfav'])), $cfg['homebreadcrumb'], true);

$t->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems,
	"BREADCRUMBS" => $catpath,
));

if(!empty($c) && is_array($structure['projects'][$c]))
{
	foreach ($structure['projects'][$c] as $field => $val)
	{
		$t->assign('CAT'.strtoupper($field), $val);
	}
}

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('projects.list.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$jj++;
	$t->assign(cot_generate_usertags($item, 'PRJ_ROW_OWNER_'));
	$t->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	$t->assign(array(
		"PRJ_ROW_ODDEVEN" => cot_build_oddeven($jj)
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.PRJ_ROWS");
}

/* === Hook === */
foreach (cot_getextplugins('projects.list.tags') as $pl)
{
	include $pl;
}
/* ===== */
