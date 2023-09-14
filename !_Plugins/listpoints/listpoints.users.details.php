<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

/**
 * ListPoints plugin
 *
 * @package listpoints
 * @version 1.0
 * @author Alexeev Vlad
 * @copyright Copyright (c) http://cmsworks.ru/users/alexvlad
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('listpoints', 'plug');

$t->assign('POINTS', cot_get_listpoints($urr['user_id'], 'userdetails'));

?>