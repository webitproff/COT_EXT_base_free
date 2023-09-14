<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

$id = cot_import('id', 'G', 'TXT');

if($id > 0 && $usr['id'] > 0) {
  $ppitem = $db->query("SELECT * FROM $db_projects as p LEFT JOIN $db_users as u ON p.item_userid=u.user_id WHERE item_id=".$id.' AND item_userid='.$usr['id'])->fetch();

  if($ppitem['item_id'] > 0) {
    require_once cot_langfile('payprojects', 'plug');

    $_PROJ = array(2 => $L['payprojects_project'], 3 => $L['payprojects_job'], 4 => $L['payprojects_konkurs']);

    $options['desc'] = $L['payprojects'].' '.$_PROJ[$ppitem['item_type']].'"'.$ppitem['item_title'].'"';

    $options['code'] = $ppitem['item_id'];
    $options['redirect'] = cot_url("projects", "id=".$ppitem['item_id']);
    $project_cost = 0;

    $_prj_cost_ = explode("|", $cfg['plugin']['payprojects']["prj_cost"]);
    $i = 1;
    foreach($_prj_cost_ as $v){
      $prj_cost[$i++] = $v;
    }
    if(empty($ppitem["item_type"]) || $ppitem["item_type"] == 0){
      $project_cost = $prj_cost[1];
    } else {
      $project_cost = $prj_cost[$ppitem["item_type"]];
    }

    $ispro = 0;
    if($ppitem['user_pro'] - time() >= 1){
      $ispro = 1;
      $project_cost = $project_cost - ($project_cost / 100) * $cfg['plugin']['payprojects']["discount_forpro"];
    }

    if($project_cost > 0) {
      require_once cot_incfile('payments', 'module');

      $_pays = cot_payments_getallpays('prj.save', 'done');
      $pays = array();
      if(is_array($_pays)) {
        foreach ($_pays as $p){
          $pays[$p['pay_code']][$p['pay_id']] = $p;
        }
      }
      if (!$pays[$ppitem['item_id']]) {
        $db->update($db_projects, array('item_state' => 1), 'item_id='.$ppitem["item_id"]);
        cot_payments_create_order('prj.save', $project_cost, $options);
        exit;
      }
    }
  } else {
    cot_die_message(404);
  }
} else {
  cot_die_message(404);
}