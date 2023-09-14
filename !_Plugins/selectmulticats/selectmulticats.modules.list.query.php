<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.list.query,uslugi.list.query,market.list.query,folio.list.query
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

$multicats = cot_import('multicats', 'G', 'ARR');
if(count($multicats) > 0)
{
  $where['cat'] = array();
  foreach($multicats as $cc) {
    $where['cat'][] = "FIND_IN_SET('".$cc."', item_multicat)";
  }
  $where['cat'] = implode(' OR ', $where['cat']);
}

?>
