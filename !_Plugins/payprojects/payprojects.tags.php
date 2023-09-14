<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.tags
 * [END_COT_EXT]
 */
require_once cot_langfile('payprojects', 'plug');

$ispro = cot_getuserpro($usr["id"]);

$_prj_cost_ = explode("|", $cfg['plugin']['payprojects']["prj_cost"]);
$i = 1;
foreach ($_prj_cost_ as $v){
  $prj_cost[$i++] = $v;
}

if(empty($_GET['type'])) {
  $project_cost = $prj_cost[1];
} else {
  $project_cost = $prj_cost[$_GET['type']];
}

$ispro = cot_getuserpro();
if($ispro - $sys['now'] >= 1){
  $project_cost = $project_cost - ($project_cost / 100) * $cfg['plugin']['payprojects']["discount_forpro"];
}

$t->assign(array(
  "PRJADD_FORM_PROJECT_COST" => $project_cost,
));