<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.edit.tags
  Tags=users.edit.tpl:{USERS_EDIT_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('prjmap', 'plug');
$t->assign('USERS_EDIT_PRJMAP', cot_prjmap_user_form($urr));
$t->assign('USERS_EDIT_MAPRADIUS', cot_selectbox($urr['user_mapradius'], 'rusermapradius', array_keys($prjmap_mapradius), array_values($prjmap_mapradius), false, 'class="form-control"'));
