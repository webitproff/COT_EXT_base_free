<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.add.first
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

$ruser['user_adr'] = cot_import('ruseradr', 'P', 'TXT'); 