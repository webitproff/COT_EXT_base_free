<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.register.add.validate
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

$ruser['user_mobile'] = cot_import('rusermobile', 'P', 'TXT');
$phonehash = cot_import('reg_lastphone', 'C', 'TXT');

if (!empty($ruser['user_mobile']) && $ruser['user_usergroup'] == 4) {
    if(md5($ruser['user_mobile'].$sys['site_id']) != $phonehash) {
        cot_error($L['users_register_error_phone_notconfirmed'], 'rusermobile');
    }
}
