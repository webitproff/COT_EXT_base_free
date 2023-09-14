<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.list.tags
  Tags=projects.list.tpl:{PRJ_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if (cot_plugin_active('locationselector'))
{
require_once cot_incfile('prjmap', 'plug');
$center = cot_geoinfo_to_map($cfg['plugin']['prjmap']['center']);
                                                                    
$t_i = new XTemplate(cot_tplfile(array('prjmap', 'infowindow'), 'plug'));                                                                    
$t_m = new XTemplate(cot_tplfile(array('prjmap', 'list.script'), 'plug'));

if ($mapzoom)
{
 $t_m->assign(array(
  'MAP_ZOOM_FIX' => $mapzoom,
 ));
}

if ($center)
{
  $sqllist = $db->query("SELECT * FROM $db_projects as p $join_condition
  ".$where.((!cot_import('city', 'G', 'INT') && $usr_geoinfo['city'] > 0) ? " AND item_city=".$usr_geoinfo['city'] : '')." 
  " . $group . "
	ORDER BY item_date DESC");

 foreach($sqllist->fetchAll() as $item)
 {
  $prjtags = cot_generate_projecttags($item, 'PRJ_ROW_');
  $t_m->assign($prjtags);
  $t_m->assign(array(
  'PRJ_ROW_TEXT' => preg_replace("/(\r\n)/", "' + '", $prjtags['PRJ_ROW_TEXT']),
  'PRJ_ROW_SHORTTEXT' => preg_replace("/(\r\n)/", "' + '", $prjtags['PRJ_ROW_SHORTTEXT']),
  ));
  
  $t_i->assign($prjtags);
  $t_i->parse("MAIN");
  $t_m->assign('CONTENT', preg_replace("/('|\"|\r?\n)/", '', $t_i->text("MAIN")));
  
	$t_m->parse("MAIN.PRJMAP_ROWS");
 }
}
else
{
$t_m->assign(array('ERROR' => 1));
}

$t_m->parse("MAIN");
$t->assign('PRJ_PRJMAP', $t_m->text("MAIN"));
}

