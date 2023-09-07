<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=news.loop
Order=11
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

$page_urlp = empty($pag['page_alias']) ? 'c='.$pag['page_cat'].'&id='.$pag['page_id'] : 'c='.$pag['page_cat'].'&al='.$pag['page_alias'];
$news->assign(array(
	'PAGE_ROW_COMMENTS' => cot_modercom_comments_link('page', $page_urlp, 'page', $pag['page_id'], $pag['page_cat'], $pag),	
	'PAGE_ROW_COMMENTS_COUNT' => cot_modercom_comments_count('page', $pag['page_id'], $pag)
));

?>