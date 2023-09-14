<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rc
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

cot_rc_add_file($cfg['plugins_dir'] . '/geotargeting/js/geotargeting.js');
cot_rc_add_file($cfg['plugins_dir'] . '/geotargeting/css/geotargeting.css');