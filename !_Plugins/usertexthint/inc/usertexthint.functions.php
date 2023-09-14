<?php
defined('COT_CODE') or die('Wrong URL');

function cot_usertexthint($catname = 'rcats[]')
{
  global $db, $db_structure, $structure, $cfg;
  $return = '';
  if(cot_plugin_active('usercategories')) {
    $cathint = $cfg['plugin']['usertexthint']['column'];
    $catjson = array();

    if(is_array($structure['usercategories'])) foreach($structure['usercategories'] as $st) {
      $st['path_s'] = explode('.', $st['path']);
      $st['path_s'] = array_pop($st['path_s']);
      $catjson[$st['path_s']] = $st[$cathint];
    }

    $t1 = new XTemplate(cot_tplfile(array('usertexthint'), 'plug'));
    $t1->assign(array(
      "CATNAME" => $catname,
      "CATJSON" => json_encode($catjson)
    ));
    $t1->parse('MAIN');
    $return = $t1->text('MAIN');
  }
  return $return;
}