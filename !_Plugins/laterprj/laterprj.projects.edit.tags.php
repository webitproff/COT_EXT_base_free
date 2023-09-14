<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.tags
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

$t->assign(array(
	"PRJEDIT_FORM_LATERPRJ" => cot_selectbox_date($item['item_laterprj'], 'short', 'rlaterprj', (int)cot_date('Y', ($sys['now'] > $item['item_laterprj'] ? $item['item_laterprj'] : $sys['now']))),
));