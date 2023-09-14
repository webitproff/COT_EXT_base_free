<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=payments.billing.register
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$cot_billings['mollie'] = array(
	'plug' => 'molliebilling',
	'title' => 'Mollie',
	'icon' => $cfg['plugins_dir'] . '/molliebilling/images/mollie.png'
);

?>