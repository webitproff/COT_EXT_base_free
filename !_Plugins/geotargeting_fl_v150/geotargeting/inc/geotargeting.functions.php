<?php
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.4
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_langfile('geotargeting', 'plug');

/**
 * Функции плагина Geo Targeting
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */

function cot_geoinfo_to_localselect($geocountry = '', $geocity = '')
{
	global $db_ls_cities, $db;
  
  $usr_geoinfo['region'] = '';
	$usr_geoinfo['city'] = ''; 
  $usr_geoinfo['country'] = $geocountry;
      
  if (cot_plugin_active('locationselector')) {
    require_once cot_incfile('locationselector', 'plug');

    $geo_search = $db->query("SELECT * FROM $db_ls_cities WHERE city_country='$geocountry' AND city_name='$geocity'")->fetch();
    if(!empty($geo_search)) {
     $usr_geoinfo['country'] = $geo_search['city_country'];
     $usr_geoinfo['region'] = $geo_search['city_region'];
     $usr_geoinfo['city'] = $geo_search['city_id'];
    }
  }
  return $usr_geoinfo;
}

function cot_import_geolocation($source = 'P')   //Получаем выбранные данные
{
	$result['country'] = cot_import('country',$source, 'TXT');
	$result['region'] = cot_import('region', $source, 'INT');
	$result['city'] = cot_import('city', $source, 'INT');
  //Проверяем если не выбран регион/город, куки не записываем
  $result['country'] = ($result['country'] != '0') ? $result['country'] : null;
	$result['region'] = ($result['region'] != '0') ? $result['region'] : null;
	$result['city'] = ($result['city'] != '0') ? $result['city'] : null;

	return $result;
}

function cot_geotargeting_header_tpl($template ='', $usr_geoinfo, $select_geo, $geo_fordrop, $url = '')
{
  global $L;
  
	$t1 = new XTemplate(cot_tplfile(array('geotargeting', $template), 'plug'));
  if ($template == 'modal')
  {
    $t1->assign(array(
    'GEOTARGETING_SUBMIT' => $url,
   	'GEOTARGETING_SEARCH' => (function_exists('cot_select_location')) ?
  			cot_select_location($usr_geoinfo['country'], $usr_geoinfo['region'], $usr_geoinfo['city']) : '',
    ));

    if (!cot_plugin_active('locationselector'))     /* fix при отключении плагина locationselector */
    {
      $t1->assign(array(
     	 'GEOTARGETING_SEARCH' => 'Включите плагин LocationSelector',
      ));
    }
  }
  $t1->assign(array(
    //если выбран город, пишем город для региона соответственно, если ничего не выбранно пишем "выберите город"
    'GEOTARGETING_NAME_SELECT' => (!empty($select_geo)) ? $select_geo : $L['select_city'],
    'GEOTARGETING_DROP_OPEN' => (!empty($select_geo) && !empty($geo_fordrop)) ? 'open' : '',
    'GEOTARGETING_MODAL_BUTTON' => (!empty($geo_fordrop)) ? 1 : 0,
  ));
	
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}  
?>