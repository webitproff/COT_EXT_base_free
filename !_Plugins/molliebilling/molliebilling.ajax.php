<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('molliebilling', 'plug');

list($mollie, $mollie_status) = cot_molliebilling_get();

if($mollie_status['code']) {
  try {
    $payment = $mollie->payments->get($_POST["id"]);
    $orderId = $payment->metadata->order_id;

    require_once cot_incfile('payments', 'module');

    $pinfo = $db->query("SELECT * FROM $db_payments
    	WHERE pay_id='" . (int)$orderId . "' LIMIT 1")->fetch();

    if ($pinfo['pay_id'] > 0)
    {
      if($pinfo['pay_status'] == 'process') {
        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
          cot_payments_updatestatus($pinfo['pay_id'], 'paid');
        } elseif ($payment->isOpen()) {
            /*
             * The payment is open.
             */
        } elseif ($payment->isPending()) {
            /*
             * The payment is pending.
             */
        } elseif ($payment->isFailed()) {
            cot_payments_updatestatus($pinfo['pay_id'], 'fail');
        } elseif ($payment->isExpired()) {
            cot_payments_updatestatus($pinfo['pay_id'], 'expired');
        } elseif ($payment->isCanceled()) {
            cot_payments_updatestatus($pinfo['pay_id'], 'cancel');
        } elseif ($payment->hasRefunds()) {
            cot_payments_updatestatus($pinfo['pay_id'], 'refunded');
        } elseif ($payment->hasChargebacks()) {
            cot_payments_updatestatus($pinfo['pay_id'], 'chargedback');
        }
      }
    }
  } catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
  }
}
