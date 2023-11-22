<?php

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('request', 'plug');

// Tables and extras
cot::$db->registerTable('requests');
cot::$db->registerTable('requests_pilots');