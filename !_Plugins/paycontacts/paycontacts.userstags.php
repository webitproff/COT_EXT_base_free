<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * Order=99
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paycontacts', 'plug');

$temp_array['CONTACTS_SHOW'] = (!empty($user_data)) ? cot_getpaycontacts($user_data) : '';

$temp_array['PM'] = cot_getpaycontactspm($user_data, $temp_array['PM']);
$temp_array['PMNOTIFY'] = cot_getpaycontactspm($user_data, $temp_array['PMNOTIFY']);
 