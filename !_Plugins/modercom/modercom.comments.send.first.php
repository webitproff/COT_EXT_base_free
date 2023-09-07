<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=comments.send.first
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if(!$usr['isadmin'])
{
	$comarray['com_state'] = 1;	
}

?>