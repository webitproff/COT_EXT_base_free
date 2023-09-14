<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if($usr['id'] > 0) {
  require_once cot_incfile('payments', 'module');
  require_once cot_incfile('sberbankbilling', 'plug');

  $paycheck = $db->query("SELECT * FROM $db_payments WHERE pay_userid=".$usr['id']." AND pay_status='process' AND pay_sberbank_check>0 AND
    (pay_cdate<".($sys['now']-3600*3)."
     OR (pay_cdate<".($sys['now']-3600*6)." AND pay_sberbank_check<".($sys['now']-60).")
     OR (pay_cdate<".($sys['now']-3600*12)." AND pay_sberbank_check<".($sys['now']-350).")
     OR pay_sberbank_check<".($sys['now']-600)."
    ) LIMIT 3")->fetchAll();

  foreach($paycheck as $pay) {
    if(cot_sberbankbilling_check($pay['pay_id'], $pay['pay_sberbank_id'], $pay['pay_userid'])) {
      cot_payments_updatestatus($pay['pay_id'], 'paid');
    } else {
      $db->update($db_payments, array('pay_sberbank_check' => $sys['now']), "pay_id=?", array($pay['pay_id']));
    }
  }
}