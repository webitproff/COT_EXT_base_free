<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=header.tags
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
$t->assign(array(
	'HEADER_GEOTARGETING' => cot_geotargeting_header_tpl('header', $usr_geoinfo, $select_geo, $geo_fordrop, $geo_update_url),
	'HEADER_GEOTARGETING_MODAL' => cot_geotargeting_header_tpl('modal', $usr_geoinfo, $select_geo, $geo_fordrop, $geo_update_url),
));
