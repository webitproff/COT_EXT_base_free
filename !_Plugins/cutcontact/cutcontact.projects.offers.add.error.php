<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.add.error
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
$roffer['item_text'] = cot_cutcontact($roffer['item_text'],'offer');