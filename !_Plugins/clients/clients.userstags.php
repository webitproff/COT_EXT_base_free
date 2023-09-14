<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */

/**
 * Сlients plugin
 *
 * @package clients
 * @version 1.0
 * @author Alexeev Vlad
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('clients', 'plug');
require_once cot_langfile('clients', 'plug');

$temp_array['CLIENT_COUNT'] = ($user_data['user_id'] > 0) ? cot_clients_scores($user_data['user_id']) : 0;