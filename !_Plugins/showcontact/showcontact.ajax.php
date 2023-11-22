<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $usr['id']) {

    $checkareas = array('pilot');

    $area = cot_import('area', 'G', 'ALP');
    $uri = cot_import('uri', 'G', 'TXT');
    $id = cot_import('id', 'G', 'INT');

    $yesterday = $sys['now'] - 24*60*60;

    require_once cot_incfile('showcontact', 'plug');
    require_once cot_incfile('users', 'module');

    $urr = cot_user_data($id);

    if (!empty($urr['user_id'])) {

        $cscounter = $db->query("SELECT COUNT(DISTINCT(sc_uid)) FROM $db_showcontact 
            WHERE sc_userid=".$usr['id']." AND sc_status='success' AND sc_date>".$yesterday)->fetchColumn();

        $db->insert($db_showcontact, array(
            'sc_date' => $sys['now'],
            'sc_userid' => $usr['id'],
            'sc_uid' => $urr['user_id'],
            'sc_area' => $area,
            'sc_url' => $db->prep($uri),
            'sc_status' => (in_array($area, $checkareas) && $cscounter >= $cfg['plugin']['showcontact']['daylimit']) ? 'blocked' : 'success'
        ));

        $t = new XTemplate(cot_tplfile(array('showcontact', $area), 'plug'));

        $t->assign(cot_generate_usertags($urr, 'USERS_DETAILS_'));

        $t->assign(array(
            'USERS_DETAILS_SHOWCONTACTS_BLOCKED' => (bool)(in_array($area, $checkareas) && $cscounter >= $cfg['plugin']['showcontact']['daylimit'])
        ));

        echo $t->text('MAIN');
    }
} else {
    cot_die_message(404);
}