<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

$L['plu_title'] = $L['molliebilling_title'];

require_once cot_incfile('molliebilling', 'plug');
require_once cot_incfile('payments', 'module');

$m = cot_import('m', 'G', 'ALP');
$pid = cot_import('pid', 'G', 'INT');

if (empty($m))
{
	// Получаем информацию о заказе
	if (!empty($pid) && $pinfo = cot_payments_payinfo($pid))
	{
		cot_block($usr['id'] == $pinfo['pay_userid']);
		cot_block($pinfo['pay_status'] == 'new' || $pinfo['pay_status'] == 'process');

    list($mollie, $mollie_status) = cot_molliebilling_get();

    if($mollie_status['code']) {
      $pay_desc = $pinfo['pay_desc'];
      if(!empty($cfg['plugin']['molliebilling']['paydesc'])) {
        $pay_desc_tags = $pinfo;
        $pay_desc_tags['rate'] = (float)$cfg['plugin']['molliebilling']['rate'];
        $pay_desc_tags['summ'] = cot_molliebilling_summ($pinfo['pay_summ']);
        $pay_desc_tags['rate_summ'] = cot_molliebilling_summ($pinfo['pay_summ'], 'rate');
        $pay_desc_tags['valuta'] = $cfg['plugin']['molliebilling']['valuta'];

        $pay_desc = cot_rc($cfg['plugin']['molliebilling']['paydesc'], $pay_desc_tags);
      }

      list($payment, $payment_status) = cot_molliebilling_payment($mollie, $pid, $pinfo['pay_summ'], $pay_desc);

      if($payment_status['code']) {
        cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"
        header("Location: " . $payment->getCheckoutUrl(), true, 303);
        exit;
      } else {
      	$t->assign(array(
      		"MOLLIE_TITLE" => $L['molliebilling_error_api'],
          "MOLLIE_ALERT" => 'danger',
      		"MOLLIE_ERROR" => $payment_status['error']
      	));
      	$t->parse("MAIN.ERROR");
      }
    } else {
    	$t->assign(array(
    		"MOLLIE_TITLE" => $L['molliebilling_error_api'],
        "MOLLIE_ALERT" => 'danger',
    		"MOLLIE_ERROR" => $mollie_status['error']
    	));
    	$t->parse("MAIN.ERROR");
    }
	}
	else
	{
		cot_die();
	}
}
elseif ($m == 'status')
{
	$plugin_body = $L['molliebilling_error_incorrect'];

	if (is_numeric($pid))
	{
		$pinfo = cot_payments_payinfo($pid);
		if ($pinfo['pay_status'] == 'done')
		{
			$plugin_body = $L['molliebilling_error_done'];
		}
		elseif ($pinfo['pay_status'] == 'process')
		{
			$plugin_body = $L['molliebilling_error_process'];
		}
		elseif ($pinfo['pay_status'] == 'paid')
		{
			$plugin_body = $L['molliebilling_error_paid'];
		}
    else
		{
			$plugin_body = $L['molliebilling_error_fail'];
		}
	}
	$t->assign(array(
		"MOLLIE_TITLE" => $L['molliebilling_error_title'],
		"MOLLIE_ERROR" => $plugin_body
	));
	$t->parse("MAIN.ERROR");
}
?>