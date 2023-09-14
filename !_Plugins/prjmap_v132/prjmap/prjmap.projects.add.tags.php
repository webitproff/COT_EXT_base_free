<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.add.tags
  Tags=projects.add.tpl:{PRJADD_FORM_ADR}
  [END_COT_EXT]
  ==================== */


defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('PRJADD_FORM_ADR', cot_prjmap_form());