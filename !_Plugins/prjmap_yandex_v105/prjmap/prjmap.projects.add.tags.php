<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.add.tags
  Tags=projects.add.tpl:{PRJADD_FORM_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_prjmap_form(array(), 'prj');
$t->assign('PRJADD_FORM_PRJMAP', $route);


