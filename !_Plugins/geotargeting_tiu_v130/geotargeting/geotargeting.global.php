<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * Order=90
 * [END_COT_EXT]
 */
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('geotargeting', 'plug');
cot_load_location();
$geo_admin = ($_SERVER['SCRIPT_NAME'] = '/admin.php') ? false : true; //если удалить, в админке не будет селектора стран/регионов/городов
$geo = cot_import('geo', 'P', 'TXT');

if ($geo == 'update')
{
  //Получаем из формы выбранные города
  $geo_save = cot_import_geolocation('P');
  //Устанавливаем соответствующие куки
  cot_setcookie('geoCountry', $geo_save['country']);
  cot_setcookie('geoRegion', $geo_save['region']);
  cot_setcookie('geoCity', $geo_save['city']);

  $usr_geoinfo['country'] = $geo_save['country'];     //fix  )
  $usr_geoinfo['region'] = $geo_save['region'];       //fix  } для того что бы в случае перевыбора, информация применилась стразу
  $usr_geoinfo['city'] = $geo_save['city'];           //fix  )
  
  $geo_temp = $geo_save['country'];  //fix для "автоматического фильтра по найденому городу если пользователь еще не выбирал"
}
else
{
  //Проверяем есть ли информация о выбраном городе/регионе пользователя
  if (empty($_COOKIE['geoCountry'])) //Если информации нет, находим с помошью плагина SxGeo
  {
  if ($cfg['plugin']['geotargeting']['integrationsxgeo'] && cot_plugin_active('sxgeo')) {  //Проверяем включена ли интеграция с плагином SxGeo
	  require_once cot_incfile('sxgeo', 'plug');   //Инициализация SxGeo
    $usr_SxGeo = sx_getCityInfoExt($sx_ip);      //Инициализация SxGeo
    
    $geo_country = (!empty($usr_SxGeo['country']['iso'])) ? mb_strtolower($usr_SxGeo['country']['iso']) : '';
    $geo_city = (!empty($usr_SxGeo['city']['name_ru'])) ? $usr_SxGeo['city']['name_ru'] : ''; 
  
    $usr_geoinfo = cot_geoinfo_to_localselect($geo_country, $geo_city);  //Преобразуем получанные данные для вывода в форму
    //FIX для всплывающего меню
    $geo_fordrop = $usr_geoinfo['city'];

     //Если в настройках включен показ найденого города только 1 раз
     if ($cfg['plugin']['geotargeting']['oneshowgeo']) {
     cot_setcookie('geoCountry', $usr_geoinfo['country']);
     }
    }
  }
  else   //Если есть, берем информацию из куки
  {
  $usr_geoinfo['country'] = $_COOKIE['geoCountry'];
  $usr_geoinfo['region'] = $_COOKIE['geoRegion'];
  $usr_geoinfo['city'] = $_COOKIE['geoCity'];
  }
}

$select_geo = (!empty($usr_geoinfo['city'])) ? cot_getcity($usr_geoinfo['city']) : '';
$select_geo = (empty($select_geo) && !empty($usr_geoinfo['region']) ? cot_getregion($usr_geoinfo['region']) : $select_geo);