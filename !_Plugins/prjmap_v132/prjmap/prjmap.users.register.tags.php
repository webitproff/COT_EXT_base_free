<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.tags
  Tags=users.register.tpl:{USERS_REGISTER_ADR}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('USERS_PROFILE_ADR', cot_prjmap_form(array(), 'usr'));


