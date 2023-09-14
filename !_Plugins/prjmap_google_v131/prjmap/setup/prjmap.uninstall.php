<?php
/**
 * Projects on google maps
 * @Version 1.2
 * @package prjmap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('extrafields');
global $db_projects;
if ($db->query("SHOW COLUMNS FROM `$db_projects` WHERE `Field` = 'item_ADR'")->rowCount() != 0)
{
 cot_extrafield_remove($db_projects, 'ADR');
}