<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.list.search.tags
  Tags=projects.list.tpl:{SEARCH_PRJMAP_RADIUS}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');

$t->assign('SEARCH_PRJMAP_RADIUS', cot_selectbox(($_GET['mapradius'] ? $_GET['mapradius'] : 50), "mapradius", array(0, 10, 25, 50, 100, 200, 250, 500), array('Укажите радиус', '10 км', '25 км', '50 км', '100 км', '200 км', '250 км', '500 км'), false));