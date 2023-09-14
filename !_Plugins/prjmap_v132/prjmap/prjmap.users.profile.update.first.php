<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.profile.update.first
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL.');

$ruser['user_adr'] = cot_import('ruseradr', 'P', 'TXT'); 