<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.add.add.done
Order=99
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sendfieldstomail', 'plug');

global $usr, $db_users;

if($usr['maingrp'] != 5 && $usr['maingrp'] != 6 && $ritem['item_state'] != 2) {
  $sendfieldstomail = ($usr['id'] > 0) ? $db->query("SELECT user_email FROM $db_users WHERE user_id=".$usr['id']." LIMIT 1")->fetchColumn() :
                                          $ritem['item_'.strtoupper($cfg['plugin']['sendfieldstomail']['sftm_market_field'])];

  if($id && !empty($sendfieldstomail)) {
    cot_sendfieldstomail($sendfieldstomail, 'market', $id, 'user');
  }
}

$sendfieldstomail = !empty($cfg['plugin']['sendfieldstomail']['sftm_emails']) ? $cfg['plugin']['sendfieldstomail']['sftm_emails'] : $cfg['adminemail'];
if($id && !empty($sendfieldstomail)) {
  cot_sendfieldstomail($sendfieldstomail, 'market', $id, 'admin');
}

?>
