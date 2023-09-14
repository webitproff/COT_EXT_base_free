<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.edit.delete.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('reviewstar', 'plug');
cot_update_review_star($item['item_touserid']);

?>