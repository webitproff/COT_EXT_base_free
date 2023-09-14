<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.choise.first
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');
if (!$usr['isadmin'] && $offer['offer_choise'] == 'refuse')
{
	$choise_enabled = false;
}
