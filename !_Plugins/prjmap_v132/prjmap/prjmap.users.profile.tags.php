<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.profile.tags
  Tags=users.profile.tpl:{USERS_PROFILE_ADR}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('USERS_PROFILE_ADR', cot_prjmap_form($urr, 'usr'));