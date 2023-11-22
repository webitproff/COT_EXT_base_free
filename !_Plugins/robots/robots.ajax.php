<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sitemap', 'plug');

header('Content-Type: text/plain; charset=utf-8');

echo $cfg['plugin']['robots']['text'];

exit();
