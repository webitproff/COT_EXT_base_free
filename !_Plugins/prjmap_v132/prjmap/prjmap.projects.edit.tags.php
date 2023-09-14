<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.edit.tags
  Tags=projects.edit.tpl:{PRJEDIT_FORM_ADR}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('PRJEDIT_FORM_ADR', cot_prjmap_form($item));
