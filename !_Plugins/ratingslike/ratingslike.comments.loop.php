<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.loop
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('ratings', 'plug');
require_once cot_incfile('ratingslike', 'plug');

list ($ratingslike_display, $ratingslike_summ) = cot_ratings_like_display('com', 'like_'.$row['com_id'], $cat);

$t->assign(array(
	'COMMENTS_ROW_LIKERATINGS_DISPLAY' => $ratingslike_display,
));

?>