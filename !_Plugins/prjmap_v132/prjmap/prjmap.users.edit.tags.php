<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.edit.tags
  Tags=users.edit.tpl:{USERS_EDIT_ADR}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('USERS_EDIT_ADR', cot_prjmap_form($urr, 'usr'));