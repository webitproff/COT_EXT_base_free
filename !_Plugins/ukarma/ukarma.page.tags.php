<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
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

$t->assign('PAGE_UKARMA', cot_ukarma($pag['page_ownerid'], 'page', $pag['page_id']));