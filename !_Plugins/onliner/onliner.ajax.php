<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');
require_once cot_incfile('whosonline', 'plug');

$t = new XTemplate(cot_tplfile('onliner.ajax', true));

if(isset($cfg['plugin']['hits']))
{
	require_once cot_incfile('hits', 'plug');
	$stats = $db->query("SELECT stat_value FROM $db_stats WHERE stat_name='maxusers' LIMIT 1")->fetch();
	$maxusers = $stats[0];
}
$count_users = 0;
$count_guests = 0;

if(cot_plugin_active('hiddengroups'))
{
	require_once cot_incfile('hiddengroups', 'plug');
	$hiddenusers = cot_hiddengroups_get(cot_hiddengroups_mode(), 'users');
}
$ipsearch = cot_plugin_active('ipsearch');

$join_condition = "LEFT JOIN $db_users AS u ON u.user_id=o.online_userid";
if($pl_cfg['disable_guests'])
{
	$where = "WHERE o.online_userid > 0";
}
$is_user_check = 'IF(o.online_userid > 0,1,0) as is_user';
$sql_users = $db->query("
	SELECT DISTINCT u.*, o.*, $is_user_check
	FROM $db_online AS o
	$join_condition $where
	ORDER BY is_user DESC, online_lastseen DESC
");
$sql_users_count = "SELECT COUNT(*) FROM $db_online WHERE online_userid > 0";
$sql_guests_count = "SELECT COUNT(*) FROM $db_online WHERE online_userid < 0";
$who_guests = $db->query($sql_guests_count)->fetchColumn();
$who_users = $db->query($sql_users_count)->fetchColumn();
$totallines = (int)$who_users + (int)$who_guests;

foreach ($sql_users->fetchAll() as $row)
{
	if($hiddenusers && in_array($row['user_id'], $hiddenusers))
	{
		if(cot_auth('plug', 'hiddengroups', '1'))
		{
			$t->assign('USER_HIDDEN', $L['Hidden']);
		}
		else continue;
	}
	if ($row['is_user'])
	{
		$count_users++;
		$url_ipsearch = cot_url('admin',	'm=other&p=ipsearch&a=search&id='.$row['online_ip'].'&'.cot_xg());
		$t->assign(array(
				'USER_LOCATION' => htmlspecialchars($row['online_location']),
				'USER_SUBLOCATION' => htmlspecialchars($row['online_subloc']),
				'USER_IP' => $ipsearch ? cot_rc_link($url_ipsearch, $row['online_ip']) : $row['online_ip'],
				'USER_IP_URL' => $ipsearch ? $url_ipsearch : '',
				'USER_LINK' => cot_build_user($row['online_userid'], htmlspecialchars($row['online_name'])),
				'USER_LASTSEEN' => cot_build_timegap($row['online_lastseen'], $sys['now'])
		));
		$t->assign(cot_generate_usertags($row, 'USER_'));
		$t->parse('MAIN.USERS');
	}
	else
	{
		$count_guests++;
		$url_ipsearch = cot_url('admin', 'm=other&p=ipsearch&a=search&id='.$row['online_ip'].'&'.cot_xg());
		$t->assign(array(
				'GUEST_LOCATION' => htmlspecialchars($row['online_location']),
				'GUEST_SUBLOCATION' => htmlspecialchars($row['online_subloc']),
				'GUEST_IP' => $ipsearch ? cot_rc_link($url_ipsearch, $row['online_ip']) : $row['online_ip'],
				'GUEST_IP_URL' => $ipsearch ? $url_ipsearch : '',
				'GUEST_NUMBER' => $count_guests + $guest_start_num,
				'GUEST_LASTSEEN' => cot_build_timegap($row['online_lastseen'], $sys['now'])
		));
		$t->parse('MAIN.GUESTS');
	}
}
$sql_users->closeCursor();

$t->assign(array(
	'WHO_TOTALLINES' => $totallines,
	'WHO_MAXPERPAGE' => $maxuserssperpage,
	'WHO_TOTALPAGES' => $pagenav['total'],
	'STAT_MAXUSERS' => $maxusers,
	'STAT_COUNT_USERS' => $who_users,
	'STAT_COUNT_GUESTS' => $who_guests,
	'USERS' => cot_declension($who_users, $Ls['Members'], true),
	'GUESTS' => cot_declension($who_guests, $Ls['Guests'], true)
));

?>