<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['jquery'])
{
	cot_rc_add_file($cfg['plugins_dir'] . '/catselector/js/catselector.js');
}
