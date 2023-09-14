<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.add.tags,market.edit.tags
 * [END_COT_EXT]
 */
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.3
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');

if ($m == 'edit')
{
	$t->assign(array(
		"PRDEDIT_FORM_LOCATION" => cot_select_location($item['item_country'], $item['item_region'], $item['item_city'])
	)); 
}

if ($m == 'add')
{
	$t->assign(array(
		"PRDADD_FORM_LOCATION" => cot_select_location($ritem['item_country'], $ritem['item_region'], $ritem['item_city'])
	));
}

