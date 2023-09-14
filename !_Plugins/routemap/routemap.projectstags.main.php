<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=projectstags.main
  Tags=projects.tpl:{PRJ_ROUTE_FROM},{PRJ_ROUTE_TO},{PRJ_ROUTE_FULL};projects.list.tpl:{PRJ_ROW_ROUTE_FROM},{PRJ_ROW_ROUTE_TO},{PRJ_ROW_ROUTE_FULL}
  [END_COT_EXT]
  ==================== */

/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL.');
$jj_r = 1;
   
$points = explode('&', $item_data['item_route']);
$last = count($points);
$route_tags = array();
$route_tags['full'] = array();
   
foreach ($points as $r_info)
{
  $row = explode('#', $r_info);
    if ($jj_r == 1)
    {
      $route_tags['from'] = $row[0];
    }elseif ($jj_r == $last){
      $route_tags['to'] = $row[0];
    }
  $route_tags['full'][$jj_r] = $row[0];  
  $jj_r++;
}

$temp_array += array(
	'ROUTE_FROM' => $route_tags['from'],
  'ROUTE_TO' => $route_tags['to'],
	'ROUTE_FULL' => implode(', ', $route_tags['full']),
  'ROUTE_FULL_BR' => implode('<br>', $route_tags['full']),
  'ROUTE_FULL_CNT' => count($route_tags['full']),
);

