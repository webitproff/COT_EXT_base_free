<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=productstags.main
 * [END_COT_EXT]
 */
/**
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');

$location_info = cot_getlocation($prd_data['prd_country'], $prd_data['prd_region'], $prd_data['prd_city']);
$temp_array['COUNTRY'] = $location_info['country'];
$temp_array['REGION'] = $location_info['region'];
$temp_array['CITY'] = $location_info['city'];
