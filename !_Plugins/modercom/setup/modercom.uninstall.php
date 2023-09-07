<?php
/**
 * Uninstallation handler
 *
 * @package modercom
 * @version 0.1
 * @author
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'plug');

global $db_com;

// Remove column from table
if ($db->fieldExists($db_com, "com_state"))
{
	$db->query("ALTER TABLE `$db_com` DROP COLUMN `com_state`");
}

?>