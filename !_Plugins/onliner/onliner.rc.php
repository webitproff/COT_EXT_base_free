<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

cot_rc_add_file($cfg['plugins_dir'] . '/onliner/js/onliner.js');

if($cfg['plugin']['onliner']['css'])
{	
	cot_rc_add_file($cfg['plugins_dir'] . '/onliner/tpl/onliner.css');
}
?>
