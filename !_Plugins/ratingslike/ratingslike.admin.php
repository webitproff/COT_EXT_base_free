<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'ratings');
cot_block($usr['isadmin']);

require_once cot_incfile('ratings', 'plug');
require_once cot_incfile('ratingslike', 'plug');

$t = new XTemplate(cot_tplfile('ratingslike.admin', 'plug', true));

$adminhelp = $L['adm_help_ratings'];

$id = cot_import('id','G','TXT');
$area = cot_import('area','G','ALP');

list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

/* === Hook  === */
foreach (cot_getextplugins('admin.ratingslike.first') as $pl)
{
	include $pl;
}
/* ===== */

if($a == 'delete')
{
	cot_check_xg();
	$db->delete($db_ratings, 'rating_code = ' . $db->quote($id) . ' AND rating_area = ' . $db->quote($area));
	$db->delete($db_rated, 'rated_code = ' . $db->quote($id) . ' AND rated_area = ' . $db->quote($area));

	cot_message('adm_ratings_already_del');
}


$totalitems = $db->countRows($db_ratings);
$pagenav = cot_pagenav('admin', 'm=other&p=ratings', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql = $db->query("SELECT * FROM $db_ratings WHERE rating_code LIKE 'like_%' ORDER by rating_id DESC LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
$jj = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('admin.ratingslike.loop');
/* ===== */
foreach ($sql->fetchAll() as $row)
{
	$id2 = $row['rating_code'];
	$sql1 = $db->query("SELECT COUNT(*) FROM $db_rated WHERE rated_code=" . $db->quote($id2));
	$votes = $sql1->fetchColumn();

	$rat_value = str_replace('like_','',$row['rating_code']);
	
	switch($row['rating_area'])
	{
		case 'com':
			require_once cot_incfile('comments', 'plug');
			$com = $db->query("SELECT * FROM $db_com WHERE com_id=$rat_value")->fetch();
			$rat_url = cot_url('page', 'id='.$com['com_code']);
		break;
		
		case 'page':
			$rat_url = cot_url('page', 'id='.$rat_value);
		break;
		
		default:
			$rat_url = '';
		break;
	}
	
	

	$t->assign(array(
		'ADMIN_RATINGS_ROW_URL_DEL' => cot_url('admin', 'm=other&p=ratingslike&a=delete&id='.$row['rating_code'].'&area='.$row['rating_area'].'&d='.$durl.'&'.cot_xg()),
		'ADMIN_RATINGS_ROW_RATING_CODE' => $row['rating_code'],
		'ADMIN_RATINGS_ROW_RATING_AREA' => $row['rating_area'],
		'ADMIN_RATINGS_ROW_CREATIONDATE' => cot_date('datetime_medium', $row['rating_creationdate']),
		'ADMIN_RATINGS_ROW_CREATIONDATE_STAMP' => $row['rating_creationdate'],
		'ADMIN_RATINGS_ROW_VOTES' => $votes,
		'ADMIN_RATINGS_ROW_RATING_SUMM' => $row['rating_summ'],
		'ADMIN_RATINGS_ROW_RAT_URL' => $rat_url,
		'ADMIN_RATINGS_ROW_ODDEVEN' => cot_build_oddeven($ii)
	));
	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */
	$t->parse('MAIN.RATINGS_ROW');
	$ii++;
	$jj = $jj + $votes;
}

$t->assign(array(
	'ADMIN_RATINGS_URL_CONFIG' => cot_url('admin', 'm=config&n=edit&o=plug&p=ratings'),
	'ADMIN_RATINGS_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_RATINGS_PAGNAV' => $pagenav['main'],
	'ADMIN_RATINGS_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_RATINGS_TOTALITEMS' => $totalitems,
	'ADMIN_RATINGS_ON_PAGE' => $ii,
	'ADMIN_RATINGS_TOTALVOTES' => $jj
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextplugins('admin.ratingslike.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
if (COT_AJAX)
{
	$t->out('MAIN');
}
else
{
	$adminmain = $t->text('MAIN');
}

?>
