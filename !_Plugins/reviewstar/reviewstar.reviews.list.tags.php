<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.list.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('reviewstar', 'plug');

$t1->assign(array(
  'REVIEW_ROW_RATY' => cot_reviewstar_form('SHOW', $item['item_rquality'], $item['item_rcost'], $item['item_ramity'], $item['item_id'])
));
      
?>