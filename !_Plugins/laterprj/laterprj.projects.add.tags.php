<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.tags
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

$t->assign(array(
	"PRJADD_FORM_LATERPRJ" => cot_selectbox_date($sys['now'], 'short', 'rlaterprj', (int)cot_date('Y', $sys['now'])),
));