<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

/**
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */

if(cot_plugin_active('autocomplete')){
	if ($cfg['jquery'] && $cfg['turnajax'] && $cfg['plugin']['autocomplete']['autocomplete'] > 0)
	{
		cot_rc_add_embed('favoriteusers', '
			$(document).ready(function(){
			    $( document ).on( "focus", ".favuinput", function() {
			        $(".favuinput").autocomplete("index.php?r=autocomplete", {multiple: false, minChars: '.$cfg['plugin']['autocomplete']['autocomplete'].'});
			    });
			});
		');
	}
}