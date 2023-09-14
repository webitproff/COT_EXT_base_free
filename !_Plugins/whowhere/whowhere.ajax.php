<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'whowhere', 'RWA');
cot_block($usr['isadmin']);

$return = array(
  'list' => array(),
  'date' => $sys['now']
);

/*
$datestart = cot_import('datestart', 'G', 'TXT');
$datestart = (!empty($datestart) ? cot_date2stamp($datestart, 'd.m.Y H:i') : 0);
if(!$datestart) $datestart = cot_date2stamp(cot_date('d.m.Y', $sys['now']), 'd.m.Y');

$dateend = cot_import('dateend', 'G', 'TXT');
$dateend = (!empty($dateend) ? cot_date2stamp($dateend, 'd.m.Y H:i') : 0);
if(!$dateend || $datestart > $dateend) $dateend = $sys['now'];
*/

$uid = cot_import('uid', 'G', 'INT');
$uip = cot_import('uip', 'G', 'TXT');

$lasttime = cot_import('lasttime', 'G', 'INT');
if(!$lasttime || (($sys['now'] - 86400) > $lasttime)) $lasttime = $sys['now'];

$whowhere = $db->query("SELECT * FROM $db_whowhere WHERE ww_date>".$lasttime.($uid > 0 ? ' AND ww_userid='.$uid : '').($uip > 0 ? " AND ww_ip='".$uip."'" : '').' ORDER BY ww_date DESC')->fetchAll();
$whowhere_cfg = cot_whowhere_cfg();

$urr_info = array();

$urr_parsed = array(
  'ids' => array(),
  'ips' => array(),
);

foreach ($whowhere as $ww)
{
  if(!$ajaxupdate || ($uid > 0 || !empty($uip)) || (($ww['ww_userid'] > 0 && !in_array($ww['ww_userid'], $urr_parsed['ids'])) || (!empty($ww['ww_ip']) && !in_array($ww['ww_ip'], $urr_parsed['ips'])))) {
    $ww_cfg = $whowhere_cfg[$ww['ww_code']];
    if(is_array($ww_cfg)) {
      if($ww['ww_userid'] > 0) $urr_parsed['ids'][] = $ww['ww_userid'];
      if(!empty($ww['ww_ip'])) $urr_parsed['ips'][] = $ww['ww_ip'];

      $ww['u_name'] = 'Гость';

      if($ww['ww_userid'] > 0) {
         if(!is_array($urr_info[$ww['ww_userid']])) {
          $urr_info[$ww['ww_userid']] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$ww['ww_userid'].' LIMIT 1')->fetch();
         }
         $ww['u_name'] = '<a href="'.cot_url('users', 'm=details&id='.$ww['ww_userid']).'">'.$urr_info[$ww['ww_userid']]['user_name'].'</a>';
      }

    	$return['list'][] = array(
        'WW_TITLE' => $ww_cfg['title']($ww),
        'WW_DATE' => cot_date('d.m.Y H:i:s', $ww['ww_date']),
        'WW_URL' => $ww['ww_var_url'],
        'WW_U_NAME' => $ww['u_name'],
        'WW_U_ID' => (int)$ww['ww_userid'],
        'WW_U_IP' => $ww['ww_ip'],
        'WW_U_MORE' => cot_url('plug', 'e=whowhere&datestart='.($datestart > 0 ? cot_date('d.m.Y H:i', $datestart) : '').'&dateend='.($dateend > 0 ? cot_date('d.m.Y H:i', $dateend) : '').'&uid='.$ww['ww_userid'].'&uip='.$ww['ww_ip'])
    	);
    }
  }
}

$return['list'] = array_reverse($return['list']);

echo json_encode($return);
exit;
