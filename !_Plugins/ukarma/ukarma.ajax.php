<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

/**
 * ukarma plugin
 *
 * @package ukarma
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$userid = cot_import('userid', 'G', 'INT');
$area = cot_import('area', 'G', 'ALP');
$code = cot_import('code', 'G', 'ALP');
$score = cot_import('score', 'G', 'INT');

if($m == 'add')
{
	$score_enabled = cot_ukarma_checkenablescore($userid, $area, $code);
	
	if(in_array($score, array(-1, 1)) &&
		!empty($userid) &&
		$score_enabled)
	{
		$rscore['ukarma_value'] = $score;
		$rscore['ukarma_userid'] = $userid;
		$rscore['ukarma_ownerid'] = $usr['id'];
		$rscore['ukarma_date'] = $sys['now'];
		$rscore['ukarma_area'] = $area;
		$rscore['ukarma_code'] = $code;

		$db->insert($db_ukarma, $rscore);
		
		$score = $db->query("SELECT SUM(ukarma_value) FROM $db_ukarma WHERE ukarma_userid=".$userid)->fetchColumn();
		$db->update($db_users, array('user_ukarma' => $score), "user_id=".$userid);
	}
}

echo cot_ukarma ($userid, $area, $code);