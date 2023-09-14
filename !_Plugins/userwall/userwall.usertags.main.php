<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userwall', 'plug');

$temp_array['LIKES'] = cot_walllikes_count($user_data['user_id']);

