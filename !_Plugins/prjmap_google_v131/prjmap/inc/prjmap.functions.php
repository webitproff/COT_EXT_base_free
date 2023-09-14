<?php
/**
 * Функции плагина Projects on Google maps
 * @Version 1.2
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
 
defined('COT_CODE') or die('Wrong URL');

function cot_geoinfo_to_map($geocity = '')
{
	global $db_ls_cities, $db;      
  $geo_search = $db->query(
	"SELECT * FROM $db_ls_cities WHERE city_name='$geocity'")->fetch(); 
  if (!empty($geo_search)) {
   $geoinfo = $geo_search['city_id'];  
  }
return $geoinfo;
}

?>