<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=pm.send.send.first
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
$newpmtitle = cot_cutcontact($newpmtitle, 'private message');
$newpmtext cot_cutcontact($newpmtext, 'private message');