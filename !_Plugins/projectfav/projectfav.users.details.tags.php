<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');

$tab = cot_import('tab', 'G', 'ALP');

list($pg, $d, $durl) = cot_import_pagenav('dprjfav', $cfg['projects']['cat___default']['maxrowsperpage']);

//маркет вкладка
$t1 = new XTemplate(cot_tplfile(array('projectfav', 'userdetails'), 'plug'));

$where = array();
$order = array();

if($usr['id'] == 0 || $usr['id'] != $urr['user_id'] && !$usr['isadmin'])
{
	$where['state'] = "item_state=0";
}

$where['owner'] = "fav_uid=" . $urr['user_id'];

$order['date'] = "item_date DESC";

$wherecount = $where;

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$wherecount = ($wherecount) ? 'WHERE ' . implode(' AND ', $wherecount) : '';
$order = ($order) ? 'ORDER BY ' . implode(', ', $order) : '';

$sql_projects_count = $db->query("SELECT * FROM $db_projects AS p
  JOIN $db_projectfav as fav ON p.item_id=fav.fav_pid
	" . $wherecount . "");
$projects_count_all = $projects_count = $sql_projects_count->rowCount();

$sqllist = $db->query("SELECT * FROM $db_projects AS p
  JOIN $db_projectfav as fav ON p.item_id=fav.fav_pid
	" . $where . "
	" . $order . "
	LIMIT $d, " . $cfg['projects']['cat___default']['maxrowsperpage']);

$opt_array = array(
					  'm' => 'details',
				  	'id'=> $urr['user_id'],
				  	'u'=> $urr['user_name'],
				    'tab' => 'projectfav'
          );

$pagenav = cot_pagenav('users', $opt_array , $d, $projects_count, $cfg['projects']['cat___default']['maxrowsperpage'], 'dprjfav');

$t1->assign(array(
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"PAGENAV_COUNT" => $projects_count,
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('projects.userdetails.loop');
/* ===== */

foreach($sqllist_rowset as $item)
{
	$t1->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

	/* === Hook === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t1->parse("MAIN.PRJ_ROWS");
}

$t1->parse("MAIN");

$t->assign(array(
	"USERS_DETAILS_PROJECTFAV_COUNT" => $projects_count_all,
	"USERS_DETAILS_PROJECTFAV_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=projectfav'),
));

$t->assign('PROJECTFAV', $t1->text("MAIN"));

