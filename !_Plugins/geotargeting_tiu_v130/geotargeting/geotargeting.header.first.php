<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=header.first
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

//fix, если данные выбираются на главной странице, добавляем пустую переменную e
$geo_update_url = $_SERVER["REQUEST_URI"];

// переменная для хука geotargeting.header.tags и для title
$select_geo = (!empty($usr_geoinfo['city'])) ? cot_getcity($usr_geoinfo['city']) : '';
$select_geo = (empty($select_geo) && !empty($usr_geoinfo['region']) ? cot_getregion($usr_geoinfo['region']) : $select_geo);
$select_geo = (empty($select_geo) && !empty($usr_geoinfo['country']) ? cot_getcountry($usr_geoinfo['country']) : $select_geo);
// Проверяем включена ли функция вывода в title выбранного города
$out['subtitle'] .= ($cfg['plugin']['geotargeting']['geotitle']) ? ' '.$select_geo : '';