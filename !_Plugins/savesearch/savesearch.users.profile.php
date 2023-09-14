<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

$tab = cot_import('tab', 'G', 'ALP');

$t1 = new XTemplate(cot_tplfile(array('savesearch', 'userdetails'), 'plug'));

$where = array();

$where['owner'] = "s_uid=" . $urr['user_id'];
$wherecount = $where;

$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql_ss_count = $db->query("SELECT * FROM $db_savesearch
	" . $where . "");
$ss_count_all = $ss_count = $sql_ss_count->rowCount();

$sqllist = $db->query("SELECT * FROM $db_savesearch
	" . $where . "
	ORDER BY s_id DESC");
$sqllist_rowset = $sqllist->fetchAll();

$s_jj = array(
  'projects' => 0,
  'market' => 0
);

foreach($sqllist_rowset as $item)
{
  $item['params'] = json_decode($item['s_params'], 1);
  $item['url_params'] = array();
  if(is_array($item['params'])) foreach($item['params'] as $key => $val) {
    $item['url_params'][] = $key.'='.$val;
  }

  if(empty($item['params']['sq'])) $s_jj[$item['s_code']]++;
  $t1->assign(array(
  	"S_HREF" => cot_url($item['s_code'], implode('&', $item['url_params']), '', true),
    "S_CODE_TEXT" => (!empty($L['savesearch_savedsearch_in_'.$item['s_code']]) ? ' '.$L['savesearch_savedsearch_in_'.$item['s_code']] : '').(!empty($item['params']['sq']) ? ' "'.$item['params']['sq'].'"' : ' №'.$s_jj[$item['s_code']]),
    "S_JJ" => $s_jj[$item['s_code']]
  ));
	$t1->parse("MAIN.S_ROWS");
}

$t1->assign("SS_СOUNT", $ss_count_all);
$t1->parse("MAIN");

$t->assign(array(
	"USERS_TAGS_SAVESEARCH_COUNT" => $ss_count_all,
	"USERS_TAGS_SAVESEARCH_URL" => cot_url('users', 'm=profile&tab=savesearch'),
));

$t->assign('SAVESEARCH', $t1->text("MAIN"));

