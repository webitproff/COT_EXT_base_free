<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.edit.tags,uslugi.edit.tags,market.edit.tags,folio.edit.tags
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$e = cot_import('e', 'G', 'TXT');
if(!empty($e) && $cfg['plugin']['selectmulticats'][$e]) {
  require_once cot_incfile('selectmulticats', 'plug');
  $t->assign(array(
  	($e == 'projects' ? "PRJ" : "PRD") . "EDIT_FORM_CAT" => cot_selectmulticats($e, $item['item_multicat'], 'rmulticats', $L[$e . '_select_cat'], $cfg['plugin']['selectmulticats']['lim_' . $e]),
  ));
}

?>