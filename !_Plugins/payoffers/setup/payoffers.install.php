<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects_offers, $cfg;

if (!$db->fieldExists($db_projects_offers, "offer_paidsumm"))
{
	$db->query("ALTER TABLE `$db_projects_offers` ADD COLUMN `offer_paidsumm` float(16,2) NOT NULL DEFAULT '0'");
}

if (!$db->fieldExists($db_projects_offers, "offer_paid"))
{
	$db->query("ALTER TABLE `$db_projects_offers` ADD COLUMN `offer_paid` int(1) NOT NULL DEFAULT 0");
}