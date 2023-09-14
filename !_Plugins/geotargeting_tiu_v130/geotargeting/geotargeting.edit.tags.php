<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags, users.register.tags, users.edit.tags
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

$prfx = 'USERS_REGISTER_';
if ($m == 'edit')
{
	$prfx = 'USERS_EDIT_';
}
elseif ($m == 'profile')
{
	$prfx = 'USERS_PROFILE_';
}
if ($prfx == 'USERS_REGISTER_')     //получаем ID выбранного региона/города для формы при регистрации
{
	$ruser['user_country'] = (!empty($_COOKIE['geoCountry'])) ? $_COOKIE['geoCountry'] : 0;
	$ruser['user_region'] = (!empty($usr_geoinfo['region'])) ? $usr_geoinfo['region'] : 0;
	$ruser['user_city'] = (!empty($usr_geoinfo['city'])) ? $usr_geoinfo['city'] : 0;
}
else
{
	$ruser['user_country'] = $urr['user_country'];
	$ruser['user_region'] = $urr['user_region'];
	$ruser['user_city'] = $urr['user_city'];
}
$t->assign(array(
	$prfx . 'LOCATION' => (function_exists('cot_select_location')) ?
			cot_select_location($ruser['user_country'], $ruser['user_region'], $ruser['user_city'], true) : '',
));
