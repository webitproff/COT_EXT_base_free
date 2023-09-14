<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

if(!$plid && ($usr['id'] > 0 || (!$cfg['plugin']['savesearch']['disable_guests'] && !empty($usr['ip'])))) {
  $ss_code = 'projects';

  $params = $_GET;
  unset($params['e']);
  unset($params['m']);

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

  $ss_exist = $db->query("SELECT * FROM $db_savesearch
      			WHERE ".($usr['id'] > 0 ? "s_uid=".$usr['id'] : "s_uip='".$usr['ip']."'")." AND s_code='".$ss_code."' AND s_var_c='".$db->prep($params['c'])."' AND s_var_sq='".$db->prep($params['sq'])."' AND MATCH(s_params) AGAINST('".json_encode($params)."' IN BOOLEAN MODE) LIMIT 1")->fetch();

  if($ss_exist['s_id'] > 0) {
    $db->update($db_savesearch, array('s_cnt' => ($ss_exist['s_cnt']+1)), 's_id='.$ss_exist['s_id']);
  } else {
    $db->insert($db_savesearch, array('s_date' => $sys['now'], 's_cnt' => 1, 's_save' => 0, 's_var_c' => $params['c'], 's_var_sq' => $params['sq'], 's_code' => $ss_code, 's_params' => json_encode($params), 's_uid' => $usr['id'], 's_uip' => $usr['ip']));
  }
}