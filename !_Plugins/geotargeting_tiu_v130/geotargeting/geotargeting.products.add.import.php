<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=products.add.add.import,products.edit.update.import
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

$location = cot_import_location('P');
$rprd['prd_country'] = $location['country'];
$rprd['prd_region'] = $location['region'];
$rprd['prd_city'] = $location['city'];