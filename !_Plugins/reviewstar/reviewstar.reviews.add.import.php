<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.add.import
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('reviewstar', 'plug');

  $rquality = cot_import('rquality', 'P', 'INT');
  $rcost = cot_import('rcost', 'P', 'INT');
  $ramity = cot_import('ramity', 'P', 'INT');
  
  ($rquality > 0) && $ritem['item_rquality'] = $rquality;
  ($rcost > 0) && $ritem['item_rcost'] = $rcost;
  ($ramity > 0) && $ritem['item_ramity'] = $ramity;

  if($cfg['plugin']['reviewstar']['autocountrate'])
  {
   $avg_star = cot_get_avg_star($rquality, $rcost, $ramity);
	 $ritem['item_score'] = ($avg_star > 2.5) ? '1' : '-1';
  }
  
?>