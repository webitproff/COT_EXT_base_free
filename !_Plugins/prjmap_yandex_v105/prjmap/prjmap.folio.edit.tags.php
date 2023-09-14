<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=folio.edit.tags
  Tags=folio.edit.tpl:{PRDEDIT_FORM_PRJMAP}
  [END_COT_EXT]
  ==================== */


defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_prjmap_form($item, 'folio');
$t->assign('PRDEDIT_FORM_PRJMAP', $route);
