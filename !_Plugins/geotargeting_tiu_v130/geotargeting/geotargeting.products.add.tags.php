<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=products.add.tags,products.edit.tags
 * [END_COT_EXT]
 */
/**
 * Geo Targeting for Cotonti
 *
 * @package geotargeting
 * @version 1.2
 * @author Alexeev vlad
 * @copyright Copyright (c) Alexeev vlad
 */
defined('COT_CODE') or die('Wrong URL.');

if ($m == 'edit')
{
	$t->assign(array(
		"PRDEDIT_FORM_LOCATION" => cot_select_location($prd['prd_country'], $prd['prd_region'], $prd['prd_city'])
	)); 
}

if ($m == 'add')
{
	$t->assign(array(
		"PRDADD_FORM_LOCATION" => cot_select_location($rprd['prd_country'], $rprd['prd_region'], $rprd['prd_city'])
	));
}

