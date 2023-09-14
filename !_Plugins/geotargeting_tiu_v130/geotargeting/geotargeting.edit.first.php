<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.edit.update.first, users.register.add.first, users.profile.update.first
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

if (function_exists('cot_import_location'))
{
	$location = cot_import_location('P');
	$ruser['user_country'] = $location['country'];
	$ruser['user_region'] = $location['region'];
	$ruser['user_city'] = $location['city'];
	$_POST['rcountry'] = $ruser['user_country'];
	$_POST['rusercountry'] = $ruser['user_country'];
}