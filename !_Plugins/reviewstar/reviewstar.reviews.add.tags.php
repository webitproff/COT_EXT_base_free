<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.add.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$t1->assign(array(
	'REVIEW_FORM_SCORE' => ($cfg['plugin']['reviewstar']['autocountrate']) ? cot_reviewstar_form('ADD') : cot_radiobox($ritem['item_score'], 'rscore', $L['reviews_score_values'], $L['reviews_score_titles']).'<br><br>'.cot_reviewstar_form('ADD')
));
      
?>