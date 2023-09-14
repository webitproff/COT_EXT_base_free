<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=folio.preview.tags,folio.tags
  Tags=folio.tpl:{PRD_PRJMAP};folio.preview.tpl:{PRD_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$route = cot_get_prjmap_map($item, 'folio');
$t->assign('PRD_PRJMAP', $route);
