<?php defined('COT_CODE') or die('Wrong URL');

global $db_projects_offers, $db_projects;

require_once cot_incfile('extrafields');

if ($db->fieldExists($db_projects_offers, "offer_buycontacts"))
{
	$db->query("ALTER TABLE `$db_projects_offers` DROP COLUMN `offer_buycontacts`");
}
/*if ($db->fieldExists($db_projects_offers, "offer_cost"))
{
	$db->query("ALTER TABLE `$db_projects_offers` DROP COLUMN `offer_cost`");
}*/
//cot_extrafield_remove($db_projects_offers, 'bc_cost');
cot_extrafield_remove($db_projects, 'contacts_for_buy');