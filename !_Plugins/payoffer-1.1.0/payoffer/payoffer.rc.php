<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

if ($cfg['jquery'] && $cfg['turnajax'] && $cfg['plugin']['autocomplete']['autocomplete'] > 0)
{
	cot_rc_add_embed('autocomplete', '
		$(document).ready(function(){
		    $( document ).on( "focus", ".userinputpayoffer", function() {
		        $(".userinputpayoffer").autocomplete("index.php?r=autocomplete", {multiple: false, minChars: '.$cfg['plugin']['autocomplete']['autocomplete'].'});
		    });
		});
	');
}
