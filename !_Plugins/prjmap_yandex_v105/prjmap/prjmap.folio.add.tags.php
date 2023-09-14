<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=folio.add.tags
  Tags=folio.add.tpl:{PRDADD_FORM_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_prjmap_form(array(), 'folio');
$t->assign('PRDADD_FORM_PRJMAP', $route);
