<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.add.add.import,market.edit.update.import
 * [END_COT_EXT]
 */
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.3
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');

$location = cot_import_location('P');
$ritem['item_country'] = $location['country'];
$ritem['item_region'] = $location['region'];
$ritem['item_city'] = $location['city'];