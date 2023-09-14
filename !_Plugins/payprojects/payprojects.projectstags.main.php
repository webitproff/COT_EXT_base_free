<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projectstags.main
 * [END_COT_EXT]
 */
require_once cot_langfile('payprojects', 'plug');

if($item_data['item_id'] > 0) {
  global $usr, $cfg;
  $ispro = cot_getuserpro($usr["id"]);

  $_prj_cost_ = explode("|", $cfg['plugin']['payprojects']["prj_cost"]);
  $i = 1;
  foreach ($_prj_cost_ as $v){
    $prj_cost[$i++] = $v;
  }

  if(empty($item_data['item_type'])) {
    $project_cost = $prj_cost[1];
  } else {
    $project_cost = $prj_cost[$item_data['item_type']];
  }

  $ispro = cot_getuserpro();
  if($ispro - $sys['now'] >= 1){
    $project_cost = $project_cost - ($project_cost / 100) * $cfg['plugin']['payprojects']["discount_forpro"];
  }

  $temp_array['PAYPROJECT_URL'] = '';
  $temp_array['PAYPROJECT_COST'] = '';

  if($project_cost > 0) {
    $_pays = cot_payments_getallpays('prj.save', 'done');
    $pays = array();
    if(is_array($_pays)) {
      foreach ($_pays as $p){
        $pays[$p['pay_code']][$p['pay_id']] = $p;
      }
    }
    if (!$pays[$item_data['item_id']]) {
      if($item_data['item_state'] == 0) $db->update($db_projects, array('item_state' => 1), 'item_id='.$item_data["item_id"]);
      $temp_array['PAYPROJECT_URL'] = cot_url('plug', 'r=payprojects&id='.$item_data["item_id"]);
      $temp_array['PAYPROJECT_COST'] = $project_cost;
    }
  }
}