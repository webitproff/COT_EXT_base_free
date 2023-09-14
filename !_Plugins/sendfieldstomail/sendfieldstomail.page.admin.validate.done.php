<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.admin.validate.done
Order=99
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sendfieldstomail', 'plug');

$sendfieldstomail = ($row['page_userid'] > 0) ? $db->query("SELECT user_email FROM $db_users WHERE user_id=".$row['page_userid']." LIMIT 1")->fetchColumn() :
                                       $row['page_'.strtoupper($cfg['plugin']['sendfieldstomail']['sftm_page_field'])];

if(empty($sendfieldstomail)) $sendfieldstomail = $row['page_'.strtoupper($cfg['plugin']['sendfieldstomail']['sftm_page_field'])];

if($id && !empty($sendfieldstomail)) {
  cot_sendfieldstomail($sendfieldstomail, 'page', $id, 'user');
}

?>
