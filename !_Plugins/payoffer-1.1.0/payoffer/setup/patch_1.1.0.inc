<?php defined('COT_CODE') or die('Wrong URL');

global $db, $db_config;

$db->update($db_config,array('config_value' => 0),"config_name='offerslimit' AND config_cat='paypro'");