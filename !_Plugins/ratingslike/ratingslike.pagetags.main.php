<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=pagetags.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('ratings', 'plug');
require_once cot_incfile('ratingslike', 'plug');

list ($ratingslike_display, $ratingslike_summ) = cot_ratings_like_display('page', 'like_'.$page_data['page_id'], $page_data['page_cat']);

$temp_array['LIKERATINGS_DISPLAY'] = $ratingslike_display;

?>