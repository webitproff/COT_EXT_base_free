<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

if ($pays = cot_payments_getallpays('prj.save', 'paid')) {
  foreach ($pays as $pay) {
    if(cot_payments_updatestatus($pay['pay_id'], 'done')) {
      $db->update($db_projects, array('item_state' => 0), "item_id=" . (int) $pay['pay_code']);

      /* === Hook === */
        foreach (cot_getextplugins('payprojects.done') as $pl) {
          include $pl;
        }
      /* ===== */
    }
  }
}
