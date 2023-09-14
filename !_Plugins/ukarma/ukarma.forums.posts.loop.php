<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.loop
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

$t->assign('FORUMS_POSTS_ROW_UKARMA', cot_ukarma($row['fp_posterid'], 'forums', $row['fp_id']));