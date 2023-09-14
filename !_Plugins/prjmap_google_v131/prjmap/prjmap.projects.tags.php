<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projects.tags
  Tags=projects.tpl:{PRJ_PRJMAP}
  [END_COT_EXT]
  ==================== */

/**
 * Projects on google maps
 * @Version 1.2
 * @package prjmap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL.');

if (cot_plugin_active('locationselector') && ($item['item_ADR'] || $item['item_city']))
{
require_once cot_incfile('prjmap', 'plug');
$t_m = new XTemplate(cot_tplfile(array('prjmap', 'projects'), 'plug'));
$t_m->assign(cot_generate_projecttags($item, 'PRJ_'));
$t_m->parse("MAIN");
$t->assign('PRJ_PRJMAP', $t_m->text("MAIN"));
}

