<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=folio.list.query
Order=99
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

$c = cot_import('c', 'G', 'TXT');
if (!empty($c))
{
  $where['cat'] = array();
  $cats = explode(',', $c);
  foreach($cats as $cc) {
  	$catsub = cot_structure_children('folio', $cc);
  	if(count($catsub) > 0) {
  		foreach ($subcats as $val) {
  			$where['cat'][] = "FIND_IN_SET('".$db->prep($val)."', user_cats)";
  		}
      $c = $cc;
    }
  }
  $where['cat'] = implode(' OR ', $where['cat']);
}

?>
