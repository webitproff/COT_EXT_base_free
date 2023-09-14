<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
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

$t->assign('CLIENTS', cot_clients_row($urr['user_id'], $cfg['plugin']['clients']['clientslimit']));

?>