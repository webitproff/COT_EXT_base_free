<?php
/**
 * Installation handler
 *
 * @package modercom
 * @version 0.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'plug');

global $db_com;

// Add field if missing
if (!$db->fieldExists($db_com, "com_state"))
{
	$db->query("ALTER TABLE `$db_com` ADD COLUMN `com_state` INT( 11 ) NOT NULL DEFAULT '0'");
}

?>