<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.edit.tags
  Tags=projects.edit.tpl:{PRJEDIT_FORM_PRJMAP}
  [END_COT_EXT]
  ==================== */


defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_prjmap_form($item);
$t->assign('PRJEDIT_FORM_PRJMAP', $route);


