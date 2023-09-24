<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.addpost.error
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
$offer_post['post_text'] = cot_cutcontact($offer_post['post_text'],'offer post #'.$offer_post['post_pid']);