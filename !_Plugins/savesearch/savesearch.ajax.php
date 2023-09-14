<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

cot_sendheaders();

$a = cot_import('a', 'G', 'TXT');
if($a == 'load') {
  list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'savesearch', 'RWA');
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
  $sq = cot_import('sq', 'G', 'TXT');

  $lasttime = cot_import('lasttime', 'G', 'INT');
  if(!$lasttime || (($sys['now'] - 86400) > $lasttime)) $lasttime = $sys['now'];

  $savesearch = $db->query("SELECT * FROM $db_savesearch WHERE s_date>".$lasttime.(!empty($sq) ? " AND s_var_sq='".$db->prep($sq)."'" : '').($uid > 0 ? ' AND s_uid='.$uid : '').($uip > 0 ? " AND s_uip='".$uip."'" : '').' ORDER BY s_date DESC')->fetchAll();

  $urr_info = array();

  $urr_parsed = array(
    'ids' => array(),
    'ips' => array(),
  );

  foreach ($savesearch as $ss)
  {
    if(!$ajaxupdate || ($uid > 0 || !empty($uip)) || (($ss['s_uid'] > 0 && !in_array($ss['s_uid'], $urr_parsed['ids'])) || (!empty($ss['s_uip']) && !in_array($ss['s_uip'], $urr_parsed['ips'])))) {
      if($s['s_uid'] > 0) $urr_parsed['ids'][] = $ss['s_uid'];
      if(!empty($ss['s_uip'])) $urr_parsed['ips'][] = $ss['s_uip'];

      $ss['u_name'] = 'Гость';

      if($ss['s_uid'] > 0) {
         if(!is_array($urr_info[$ss['s_uid']])) {
          $urr_info[$ss['s_uid']] = $db->query("SELECT user_name FROM $db_users WHERE user_id=".$ss['s_uid'].' LIMIT 1')->fetch();
         }
         $ss['u_name'] = '<a href="'.cot_url('users', 'm=details&id='.$ss['s_uid']).'">'.$urr_info[$ss['s_uid']]['user_name'].'</a>';
      }

    	$return['list'][] = array(
        'SS_TITLE' => cot_savesearch_title($ss),
        'SS_DATE' => cot_date('d.m.Y H:i:s', $ss['s_date']),
        'SS_URL' => cot_savesearch_url($ss),
        'SS_U_NAME' => $ss['u_name'],
        'SS_U_ID' => (int)$ss['s_uid'],
        'SS_U_IP' => $ss['s_uip'],
        'SS_U_MORE' => cot_url('plug', 'e=savesearch&datestart='.($datestart > 0 ? cot_date('d.m.Y H:i', $datestart) : '').'&dateend='.($dateend > 0 ? cot_date('d.m.Y H:i', $dateend) : '').'&uid='.$ss['s_uid'].'&uip='.$ss['s_uip'])
    	);
    }
  }

  $return['list'] = array_reverse($return['list']);

  echo json_encode($return);
  exit;
} elseif($a == 'load_phrase') {
  $code = cot_import('code', 'G', 'TXT');
  $query = cot_import('phrase', 'G', 'TXT');
  $return = array();

  $limit = 9;
  $showed = array();

  $searchrequest = $db->query("SELECT s_var_sq, sum(s_cnt) as s_cnt_summ FROM $db_savesearch WHERE ".($code != 'all' ? "s_code='".$db->prep($code)."' AND " : '')." LOWER(s_var_sq) LIKE '".strtolower($query)."%' GROUP BY s_var_sq ORDER BY s_cnt DESC LIMIT ".$limit)->fetchAll();
  foreach($searchrequest as $qry) {
    $qry['s_var_sq'] = ucfirst(mb_strtolower($qry['s_var_sq']));
    if(!in_array($qry['s_var_sq'], $showed)) {
      $return[] = array(
        'suggestion' => $qry['s_var_sq'],
        'excerpt' => preg_replace("/($query)/iu",'<b>$1</b>', $qry['s_var_sq']),
        'cnt' => $qry['s_cnt_summ'],
      );
      $showed[] = $qry['s_var_sq'];
      $limit--;
    }
  }

  if($limit > 0) {
    $searchrequest = $db->query("SELECT s_var_sq, sum(s_cnt) as s_cnt_summ FROM $db_savesearch WHERE ".($code != 'all' ? "s_code='".$db->prep($code)."' AND " : '')." ".(count($showed) > 0 ? "s_var_sq!='".implode("' AND s_var_sq!='", $showed)."' AND " : '')." LOWER(s_var_sq) LIKE '%".strtolower($query)."%' GROUP BY s_var_sq ORDER BY s_cnt DESC LIMIT ".$limit)->fetchAll();
    foreach($searchrequest as $qry) {
      if(!in_array($qry['s_var_sq'], $showed)) {
        $return[] = array(
          'suggestion' => $qry['s_var_sq'],
          'excerpt' => preg_replace("/($query)/iu",'<b>$1</b>', $qry['s_var_sq']),
          'cnt' => $qry['s_cnt_summ'],
        );
        $showed[] = $qry['s_var_sq'];
        $limit--;
      }
    }
  }

  echo json_encode($return);
  exit;
} else {
  $code = $_GET['code'];
  $params = $_GET;
  unset($params['r']);
  unset($params['code']);

  ksort($params);
  reset($params);

  $return = count($params);

  $url_params = array();
  $url_search = array();
  foreach($params as $key => $val) {
    $val = trim($val);
    if(!empty($val)) {
      $url_params[] = $key.'='.$val;
      $url_search[$key] = $val;
    }
  }

  $params = $url_search;
  $params_cnt = count($params);

  if(!empty($code) && $params_cnt > 0 && $usr['id'] > 0)
  {
    $issave = $db->query("SELECT * FROM $db_savesearch
    			WHERE s_uid=".$usr['id']." AND s_code='".$code."' AND s_var_c='".$db->prep($params['c'])."' AND s_var_sq='".$db->prep($params['sq'])."' AND MATCH(s_params) AGAINST('".json_encode($params)."' IN BOOLEAN MODE) LIMIT 1")->fetch();

    $res = array('status' => 'success', 'text' => 'Error');

    if($issave['s_id'] > 0)
    {
      $db->update($db_savesearch, array('s_save' => ($issave['s_save'] ? 0 : 1)), "s_uid=".$usr['id']." AND s_code='".$code."' AND s_var_c='".$db->prep($params['c'])."' AND s_var_sq='".$db->prep($params['sq'])."' AND MATCH(s_params) AGAINST('".json_encode($params)."' IN BOOLEAN MODE)");
      $res["text"] = ($issave['s_save'] ? $L['savesearch_star_unset_action'] : $L['savesearch_star_set_action']);
    }
    else
    {
      $db->insert($db_savesearch, array('s_date' => $sys['now'], 's_cnt' => 1, 's_save' => 1, 's_var_c' => $params['c'], 's_var_sq' => $params['sq'], 's_code' => $code, 's_params' => json_encode($params), 's_uid' => $usr['id'], 's_uip' => $usr['ip']));
      $res["text"] = $L['savesearch_star_set_action'];
    }
    if(COT_AJAX) {
      echo json_encode($res);
    } else {
      cot_redirect(cot_url($code, implode('&', $url_params), '', true));
    }
  }
  elseif(!empty($code) && !COT_AJAX) {
    cot_redirect(cot_url($code, implode('&', $url_params), '', true));
  }
  elseif(!COT_AJAX) {
    cot_redirect(cot_url('index', '', '', true));
  }
}