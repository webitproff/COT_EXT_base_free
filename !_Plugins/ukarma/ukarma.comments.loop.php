<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.loop
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

$t->assign('COMMENTS_ROW_UKARMA', cot_ukarma($row['com_authorid'], 'com', $row['com_id']));