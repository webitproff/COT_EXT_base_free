<?php
defined('COT_CODE') or die('Wrong URL.');

cot::$db->registerTable('checkextrafields');
$db_checkextrafields = $db_x.'checkextrafields';

require_once cot_langfile('checkextrafields', 'plug');