<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.main
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');
if($usr['id'] > 0) $db->update($db_eventindicator, array('item_status' => 1), "item_status=0 AND item_userid=".$usr['id']." AND item_area='sbr' AND item_code=".$id);