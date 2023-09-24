<?php defined('COT_CODE') or die('Wrong URL');

global $db_projects_offers, $db_projects, $L;

require_once cot_incfile('extrafields');

if (!$db->fieldExists($db_projects_offers, "offer_buycontacts"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects_offers` ADD COLUMN `offer_buycontacts` tinyint(1) NOT NULL default 0");
}

/*if (!$db->fieldExists($db_projects_offers, "offer_cost"))
{
	$dbres = $db->query("ALTER TABLE `$db_projects_offers` ADD COLUMN `offer_cost` float NOT NULL");
}*/

//cot_extrafield_add($db_projects_offers, 'bc_cost', 'currency', '','','',false);
cot_extrafield_add($db_projects, 'contacts_for_buy', 'textarea', '','','',false);

//Пропатчити вже існуючі проекти
$db->query("UPDATE $db_projects SET item_contacts_for_buy = ' - не заполненно - ' WHERE item_contacts_for_buy IS NULL");