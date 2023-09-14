<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.list.query
 * Order=99
 * [END_COT_EXT]
 */
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.4
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');
$geo_temp = (!empty($geo_temp)) ? $geo_temp : $_COOKIE['geoCountry']; //fix для "автоматического фильтра по найденому городу если пользователь еще не выбирал"

if ($cfg['plugin']['geotargeting']['geofoliofilter']) //Если в настройках включен автоматический фильтр для USERS
{  
  (!empty($usr_geoinfo['country'])) && $where['user_country'] = "item_country='" . $usr_geoinfo['country']."'";
  if ((!$cfg['plugin']['geotargeting']['filternow'] && !empty($geo_temp)) || $cfg['plugin']['geotargeting']['filternow'])  //Проверяем включен ли автоматический фильтр по найденому городу если пользователь еще не выбирал
  {
   ((int) $usr_geoinfo['region'] > 0) && $where['user_region'] = "item_region=" . $usr_geoinfo['region'];
   ((int) $usr_geoinfo['city'] > 0) && $where['user_city'] = "item_city=" . $usr_geoinfo['city'];
  }
}