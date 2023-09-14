<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.preview.tags,projects.tags
  Tags=projects.tpl:{PRJ_PRJMAP};projects.preview.tpl:{PRJ_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_get_prjmap_map($item);
$t->assign('PRJ_PRJMAP', $route);