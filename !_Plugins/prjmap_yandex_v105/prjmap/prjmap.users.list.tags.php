<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.tags
  Tags=users.list.tpl:{USERS_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');

if ($map && cot_plugin_active('locationselector'))
{
  $center = cot_prjmap_geoinfo_to_map($cfg['plugin']['prjmap']['center']);

  $t_i = new XTemplate(cot_tplfile(array('prjmap', 'infowindow', 'users'), 'plug'));
  $t_m = new XTemplate(cot_tplfile(array('prjmap', 'list', 'users'), 'plug'));

  //$mapwhere = ($where) ? $where.' AND user_city='.$center : 'WHERE user_state=0 AND user_city='.$center;
  $mapwhere = $where;

  if(!$_GET['city'] && $center > 0) $mapwhere = 'WHERE user_city='.$center;

  /* === Hook === */
  foreach (cot_getextplugins('prjmap.query') as $pl)
  {
  	include $pl;
  }
  /* ===== */

  $t_m->assign(array(
    'MAP_CENTER' => ($_GET['city'] > 0 ? cot_getregion($_GET['region']).', город '.cot_getcity($_GET['city']) : ($_GET['region'] > 0 ? cot_getregion($_GET['region']) : '')),
  ));

  if ($mapzoom)
  {
   $t_m->assign(array(
    'MAP_ZOOM_FIX' => $mapzoom,
   ));
  }

    $sqllist = $db->query("SELECT * FROM $db_users
      ".$mapwhere."
    	LIMIT ".$cfg['plugin']['prjmap']['indexlimit']."");

   foreach($sqllist->fetchAll() as $urr)
   {
    $urrtags = cot_generate_usertags($urr, 'USERS_ROW_');
    $t_m->assign($urrtags);
    $t_m->assign(array(
      'urr_ROW_TEXT' => preg_replace("/(\r\n)/", "' + '", $urrtags['urr_ROW_TEXT']),
      'urr_ROW_SHORTTEXT' => preg_replace("/(\r\n)/", "' + '", $urrtags['urr_ROW_SHORTTEXT']),
    ));

    $t_i->assign($urrtags);
    $t_i->parse("MAIN");
    $t_m->assign('CONTENT', preg_replace("/('|\"|\r?\n)/", '', $t_i->text("MAIN")));

  	$t_m->parse("MAIN.USERS_ROWS");
   }

  $t_m->parse("MAIN");
  $t->assign('PRJMAP', $t_m->text("MAIN"));
}
$showmapradius = (isset($_GET['city']) || $usr_geoinfo['city'] > 0);

$list_url_path_map = $list_url_path;
$list_url_path_map['map'] = 1;
$t->assign(array(
  'SEARCH_PRJMAP_RADIUS', cot_selectbox(($_GET['mapradius'] ? $_GET['mapradius'] : 0), "mapradius", array(0, 10, 25, 50, 100, 200, 250, 500), array('Укажите радиус', '10 км', '25 км', '50 км', '100 км', '200 км', '250 км', '500 км'), false),
  'SERACH_PRJMAP_SHOW_URL' => cot_url('users', $list_url_path_map)
));
