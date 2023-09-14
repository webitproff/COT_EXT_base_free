<?php

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

global $L, $adminpath, $cfg, $sys;

$adminpath[] = $L['ads_banners'];

$fil = cot_import('fil', 'G', 'ARR');  // filters

$maxrowsperpage = $cfg['maxrowsperpage'];
list($pg, $d, $durl) = cot_import_pagenav('d', $maxrowsperpage); //page number for banners list

$list_url_path = array('m' => 'other', 'p' => 'ads');

$where = array();

if (!empty($fil))
{
	foreach ($fil as $key => $val)
	{
		$val = trim(cot_import($val, 'D', 'TXT'));
		if (empty($val) && $val !== '0')
			continue;
		if (in_array($key, array('title')))
		{
			$where[$key] = "item_" . $key . " LIKE '%" . $val . "%'";
			$list_url_path["fil[{$key}]"] = $val;
		}
		elseif ($key == 'item_userid')
		{
			$where[$key] = 'a.item_userid = '.$val;
			$list_url_path["fil[{$key}]"] = $val;
		}
		else
		{
			$where[$key] = "item_" . $key . "='" . $db->prep($val)."'";
			$list_url_path["fil[{$key}]"] = $val;
		}
	}
}
else
{
	$fil = array();
}

$act = cot_import('act', 'G', 'TXT');
if ($act == 'delete')
{
	$urlArr = $list_url_path;
	if ($pagenav['current'] > 0)
		$urlArr['d'] = $pagenav['current'];
	$id = cot_import('id', 'G', 'INT');
	
	$item = $db->query("SELECT * FROM $db_ads WHERE item_id = ".(int)$id." LIMIT 1")->fetch();
	if (!$item)
	{
		cot_error($L['No_items']." id# ".$id);
		cot_redirect(cot_url('admin', $urlArr, '', true));
	}
	
	$db->delete($db_ads, "item_id = ".(int)$id);
	if (file_exists($item['item_file']))
		unlink($item['item_file']);

	foreach ($cot_extrafields[$db_ads] as $exfld)
	{
		cot_extrafield_unlinkfiles($item['item_' . $exfld['field_name']], $exfld);
	}
	cot_message($L['alreadydeletednewentry']." # $id - {$item['item_title']}");
	cot_redirect(cot_url('admin', $urlArr, '', true));
}


$where = implode(' AND ', $where);
$where = (!empty($where)) ? 'WHERE '.$where : '';

$res = $db->query("SELECT a.*, u.* FROM $db_ads AS a LEFT JOIN $db_users as u ON a.item_userid=u.user_id $where ORDER BY item_id DESC LIMIT $d, $maxrowsperpage");
$totallines = $db->query("SELECT COUNT(*) FROM $db_ads AS a $where")->fetchColumn();
$list = $res->fetchAll();

$pagenav = cot_pagenav('admin', $list_url_path, $d, $totallines, $maxrowsperpage);

$sql = $db->query("SELECT user_id, user_name FROM $db_users ORDER BY `user_id` ASC");
$clients = $sql->fetchAll(PDO::FETCH_KEY_PAIR);
$clients = (!$clients) ? array() : $clients;

$i = $d + 1;
foreach ($list as $item)
{
	$t->assign(ads_generate_tags($item, 'LIST_ROW_'));	
	$delUrlArr = array_merge($list_url_path, array('act' => 'delete',	'id' => $item['item_id'], 'd' => $pagenav['current'],'x' => $sys['xk']));
	$t->assign(array(
    'LIST_ROW_CLIENT_TITLE' => cot_build_user($item['item_userid'], $clients[$item['item_userid']]),
		'LIST_ROW_NUM' => $i,
		'LIST_ROW_DELETE_URL' => cot_confirm_url(cot_url('admin', $delUrlArr), 'admin'),
	));
	$i++;
	$t->parse('MAIN.LIST_ROW');
}

$t->assign(array(
	'LIST_PAGINATION' => $pagenav['main'],
	'LIST_PAGEPREV' => $pagenav['prev'],
	'LIST_PAGENEXT' => $pagenav['next'],
	'LIST_CURRENTPAGE' => $pagenav['current'],
	'LIST_TOTALLINES' => $totallines,
	'LIST_MAXPERPAGE' => $maxrowsperpage,
	'LIST_TOTALPAGES' => $pagenav['total'],
	'LIST_ITEMS_ON_PAGE' => $pagenav['onpage'],
	'LIST_URL' => cot_url('admin', $list_url_path, '', true),
	'PAGE_TITLE' => $L['ads_clients'],
	'FILTER_CLIENT' => cot_selectbox($fil['item_userid'], 'fil[item_userid]', array_keys($clients), array_values($clients)),
	'FILTER_CATEGORY' => ads_selectbox($fil['cat'], 'fil[cat]', true),
	'FILTER_VALUES' => $fil
));
cot_display_messages($t);
$t->assign(array(
	'PAGE_TITLE' => $L['ads_banners'],
));