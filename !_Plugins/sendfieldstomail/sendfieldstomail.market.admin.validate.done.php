<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.admin.validate.done
Order=99
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sendfieldstomail', 'plug');

$sendfieldstomail = (!empty($item['user_email'])) ? $item['user_email'] :
                                          $item['item_'.strtoupper($cfg['plugin']['sendfieldstomail']['sftm_market_field'])];

if($id && !empty($sendfieldstomail)) {
  cot_sendfieldstomail($sendfieldstomail, 'market', $id, 'user');
}

?>
