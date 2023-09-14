<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=projectstags.main
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if($item_data['item_id'] > 0)
{
 $adr = explode('#', $item_data['item_adr']);
 $temp_array['ADR'] = $adr[0];
}

?>