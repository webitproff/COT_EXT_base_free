<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.tags
  Tags=projects.tpl:{PRJ_PRJMAP}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if ($item['item_adr'])
{
  require_once cot_incfile('prjmap', 'plug');
  $t_m = new XTemplate(cot_tplfile(array('prjmap', 'prj'), 'plug'));
  $t_m->assign(cot_generate_projecttags($item, 'PRJ_'));
  $t_m->parse("MAIN");
  $t->assign('PRJ_PRJMAP', $t_m->text("MAIN"));
}

