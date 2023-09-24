<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.send.first
[END_COT_EXT]
==================== */

/**
 * Cutting contact
 *
 * @package cutcontact
 * @copyright (c) CrazyFreeMan (simple-website.in.ua)
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('cutcontact', 'plug');
$rtext = cot_cutcontact($rtext, 'comment');