<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.setperformer
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

$indicator['item_area'] = 'useroffers';
$indicator['item_type'] = 'setperformer';
$indicator['item_code'] = $item['item_id'];
$indicator['item_date'] = (int)$sys['now'];
$indicator['item_userid'] = (int)$urr['user_id'];

cot_eventindicator_add($indicator);