<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=folio.add.add.import,folio.edit.update.import
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

$waypoints = cot_import('ritemprjmap', 'P', 'TXT');
$ritem['item_prjmap'] = '';
$ritem['item_prjmaplat'] = 0;
$ritem['item_prjmaplng'] = 0;

if (!empty($waypoints))
{
 $ritem['item_prjmap'] = $waypoints;
 $waypoints = explode('#', $waypoints);
 $waypoints = str_replace(array('(', ')'), array('', ''), $waypoints[1]);
 $waypoints = explode(',', $waypoints);

 if(is_numeric((float)$waypoints[0]) && is_numeric((float)$waypoints[1])) {
   $ritem['item_prjmaplat'] = (float)$waypoints[0];
   $ritem['item_prjmaplng'] = (float)$waypoints[1];
 }
}
