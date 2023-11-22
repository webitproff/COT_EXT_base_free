<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=header.body
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

if(strpos($out['canonical_uri'], '?') > 0) {
    $t->assign('HEADER_CANONICAL_URL', substr($out['canonical_uri'], 0, strpos($out['canonical_uri'], '?')));
}