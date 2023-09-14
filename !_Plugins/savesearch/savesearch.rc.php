<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=rc
  Order=9999
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') or die('Wrong URL');

if ($_SERVER["SCRIPT_NAME"] != "/admin.php") {
    cot_rc_link_footer("plugins/savesearch/js/savesearch.js");
}