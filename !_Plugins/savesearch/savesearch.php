<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

(defined('COT_CODE') || defined('COT_PLUG')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'savesearch', 'RWA');
cot_block($usr['isadmin']);

$sys['sublocation'] = 'Поисковая статистика';

require_once cot_incfile('users', 'module');

$a = cot_import('a', 'G', 'TXT');
if($a == 'reset') {
  $db->delete($db_savesearch, 's_save=0');
  cot_redirect(cot_url('plug', 'e=savesearch', '', true));
}

$ajaxupdate = false;

$datestart = cot_import('datestart', 'G', 'TXT');
$datestart = (!empty($datestart) ? cot_date2stamp($datestart, 'd.m.Y H:i') : 0);
if(!$datestart) {
  $datestart = cot_date2stamp(cot_date('d.m.Y', $sys['now']), 'd.m.Y');
  $ajaxupdate = true;
}

$dateend = cot_import('dateend', 'G', 'TXT');
$dateend = (!empty($dateend) ? cot_date2stamp($dateend, 'd.m.Y H:i') : 0);
if(!$dateend || $datestart > $dateend) {
  $dateend = $sys['now'];
} else {
  $ajaxupdate = false;
}

$uid = cot_import('uid', 'G', 'INT');
$uip = cot_import('uip', 'G', 'TXT');
$sq = cot_import('sq', 'G', 'TXT');

$savesearch = $db->query("SELECT * FROM $db_savesearch WHERE s_save=0 AND s_date>".$datestart." AND s_date<".$dateend.(!empty($sq) ? " AND s_var_sq='".$db->prep($sq)."'" : '').($uid > 0 ? ' AND s_uid='.$uid : '').($uip > 0 ? " AND s_uip='".$uip."'" : '').' ORDER BY s_date DESC')->fetchAll();

$urr_info = array();
$urr_parsed = array(
  'ids' => array(),
  'ips' => array(),
);

foreach ($savesearch as $ss)
{
  if(!$ajaxupdate || ($uid > 0 || !empty($uip)) || (($ss['s_uid'] > 0 && !in_array($ss['s_uid'], $urr_parsed['ids'])) || (!empty($ss['s_uip']) && !in_array($ss['s_uip'], $urr_parsed['ips'])))) {
    if($ss['s_uid'] > 0) $urr_parsed['ids'][] = $ss['s_uid'];
    if(!empty($ss['s_uip'])) $urr_parsed['ips'][] = $ss['s_uip'];

    $ss['u_name'] = 'Гость';

    if($ss['s_uid'] > 0) {
       if(!is_array($urr_info[$ss['s_uid']])) {
        $urr_info[$ss['s_uid']] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$ss['s_uid'].' LIMIT 1')->fetch();
       }
       $ss['u_name'] = '<a href="'.cot_url('users', 'm=details&id='.$ss['s_uid']).'">'.$urr_info[$ss['s_uid']]['user_name'].'</a>';
    }
    $t->assign(array(
      'SS_TITLE' => cot_savesearch_title($ss),
      'SS_DATE' => cot_date('d.m.Y H:i:s', $ss['s_date']),
      'SS_URL' => cot_savesearch_url($ss),
      'SS_U_NAME' => $ss['u_name'],
      'SS_U_ID' => $ss['s_uid'],
      'SS_U_IP' => $ss['s_uip'],
      'SS_U_MORE' => cot_url('plug', 'e=savesearch&datestart='.($datestart > 0 ? cot_date('d.m.Y H:i', $datestart) : '').'&dateend='.($dateend > 0 ? cot_date('d.m.Y H:i', $dateend) : '').'&uid='.$ss['s_uid'].'&uip='.$ss['s_uip'])
    ));

    $t->parse('MAIN.SS_ROW');
  }
}