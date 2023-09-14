<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=products.list.query
 * Order=99
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

$geo_temp = (!empty($geo_temp)) ? $geo_temp : $_COOKIE['geoCountry']; //fix для "автоматического фильтра по найденому городу если пользователь еще не выбирал"

(!empty($usr_geoinfo['country'])) && $where['prd_country'] = "prd_country='" . $usr_geoinfo['country']."'";

if ((!$cfg['plugin']['geotargeting']['filternow'] && !empty($geo_temp)) || $cfg['plugin']['geotargeting']['filternow'])  //Проверяем включен ли автоматический фильтр по найденому городу если пользователь еще не выбирал
{
  ((int) $usr_geoinfo['region'] > 0) && $where['prd_region'] = "prd_region=" . $usr_geoinfo['region'];
  ((int) $usr_geoinfo['city'] > 0) && $where['prd_city'] = "prd_city=" . $usr_geoinfo['city'];
}