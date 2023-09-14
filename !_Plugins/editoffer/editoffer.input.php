<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=input
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if($_SERVER['REQUEST_METHOD'] == 'POST' && cot_import('r', 'G', 'TXT') == 'editoffer') define('COT_NO_ANTIXSS', true);