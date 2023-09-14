<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('mailchimp', 'plug');

$tt = new XTemplate(cot_tplfile('mailchimp.tools'), 'plug');

cot_display_messages($tt);
$tt->parse('MAIN');
$plugin_body = $tt->text('MAIN');
