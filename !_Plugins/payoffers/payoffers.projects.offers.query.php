<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');
if (!$usr['isadmin'])
{
	$where['paid'] = "(o.offer_choise='performer' OR o.offer_paid!=0 OR o.offer_userid=" . $usr['id'] . ")";
}
