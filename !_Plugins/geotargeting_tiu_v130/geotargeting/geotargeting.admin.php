<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
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
defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'geotargeting', 'RWA');
cot_block($usr['isadmin']);
if (!$cot_countries) 
{
	include_once cot_langfile('countries', 'core');
}
require_once cot_incfile('forms');
if (!in_array($n, array('city', 'region', 'show')))
{
	$n = 'country';
}
require_once cot_incfile('geotargeting', 'plug', $n);
