<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projectstags.main
  Tags=projects.tpl:{PRJ_PRJMAP_ADR};projects.list.tpl:{PRJ_PRJMAP_ADR}
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

if($item_data['item_id'] > 0)
{
 require_once cot_incfile('prjmap', 'plug');
 global $usr;
 $adr = explode('#', $item_data['item_prjmap']);
 $latlng = explode(',', $adr[1]);

 $temp_array['PRJMAP_ADR'] = $adr[0];
 $temp_array['PRJMAP_LAT'] = $latlng[0];
 $temp_array['PRJMAP_LNG'] = $latlng[1];
 $temp_array['PRJMAP_DIST'] = cot_prjmap_getdistance(array($item_data['item_prjmaplat'], $item_data['item_prjmaplng']), $usr['profile'], 'text');
}
