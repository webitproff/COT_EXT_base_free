<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.loop
Tags=page.list.tpl:{LIST_ROW_COMMENTS}
[END_COT_EXT]
==================== */

/**
 * Comments system for Cotonti
 *
 * @package modercom
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('modercom', 'plug');

$page_urlp = empty($pag['page_alias']) ? array('c' => $pag['page_cat'], 'id' => $pag['page_id']) : array('c' => $pag['page_cat'], 'al' => $pag['page_alias']);
$t->assign(array(
	'LIST_ROW_COMMENTS' => cot_modercom_comments_link('page', $page_urlp, 'page', $pag['page_id'], $c, $pag),
	'LIST_ROW_COMMENTS_COUNT' => cot_modercom_comments_count('page', $pag['page_id'], $pag)
));

?>