<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.delete.done
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

$ukarmas = $db->query("SELECT * FROM $db_ukarma WHERE ukarma_area='forums' AND ukarma_userid=".$row['fp_posterid']." AND ukarma_code=".$p)->fetchAll();
if(is_array($ukarmas))
{
	foreach ($ukarmas as $ukarma) {
		$score = $db->query("SELECT SUM(ukarma_value) FROM $db_ukarma WHERE ukarma_userid=".$ukarma['ukarma_userid'])->fetchColumn();
		$score = $score - $ukarma['ukarma_value'];
		
		$db->update($db_users, array('user_ukarma' => $score), "user_id=".$ukarma['ukarma_userid']);
		$db->delete($db_ukarma, "ukarma_id=".$ukarma['ukarma_id']);
	}
}