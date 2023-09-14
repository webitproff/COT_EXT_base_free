<?php

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('molliebilling', 'plug');

function cot_molliebilling_cfg_valuta($name, $value) {
  global $molliebilling_currency;

  $return = array();
  foreach(array(
    "AED" => "United Arab Emirates dirham",
    "AUD" => "Australian dollar",
    "BGN" => "Bulgarian lev",
    "BRL" => "Brazilian real",
    "CAD" => "Canadian dollar",
    "CHF" => "Swiss franc",
    "CZK" => "Czech koruna",
    "DKK" => "Danish krone",
    "EUR" => "Euro",
    "GBP" => "British pound",
    "HKD" => "Hong Kong dollar",
    "HRK" => "Croatian kuna",
    "HUF" => "Hungarian forint",
    "ILS" => "Israeli new shekel",
    "ISK" => "Icelandic króna",
    "JPY" => "Japanese yen",
    "MXN" => "Mexican peso",
    "MYR" => "Malaysian ringgit",
    "NOK" => "Norwegian krone",
    "NZD" => "New Zealand dollar",
    "PHP" => "Philippine piso",
    "PLN" => "Polish złoty",
    "RON" => "Romanian leu",
    "RUB" => "Russian ruble",
    "SEK" => "Swedish krona",
    "SGD" => "Singapore dollar",
    "THB" => "Thai baht",
    "TWD" => "New Taiwan dollar",
    "USD" => "United States dollar",
    "ZAR" => "South African rand",
  ) as $k => $v) {
    $return[$k] = $k.' ('.$v.')';
  }

  return cot_selectbox($name['config_value'], $name['config_name'], array_keys($return), array_values($return), false);
}

function cot_molliebilling_summ($cost = 0, $type = 'summ') {
  global $cfg;
  $summ = $cost;
  if(is_numeric($cfg['plugin']['molliebilling']['rate']) && $cfg['plugin']['molliebilling']['rate'] != 0) $summ = $summ * $cfg['plugin']['molliebilling']['rate'];

  if($type == 'rate') {
    $summ = ($summ >= $cost ? ($summ - $cost) : ($cost - $summ));
  }

  return number_format($summ, (in_array($cfg['plugin']['molliebilling']['valuta'], array('ISK', 'JPY')) ? 0 : 2), '.', '');
}

function cot_molliebilling_get() {
  global $cfg;

  require_once cot_incfile('molliebilling', 'plug', 'autoload');

  $status = array(
    'code' => 1,
    'error' => '',
  );
  $mollie = new \Mollie\Api\MollieApiClient();
  try {
    if($cfg['plugin']['molliebilling']['apitype'] == 'ApiKey') {
      $mollie->setApiKey($cfg['plugin']['molliebilling']['apikey']);
    } elseif($cfg['plugin']['molliebilling']['apitype'] == 'AccessToken') {
      $mollie->setAccessToken($cfg['plugin']['molliebilling']['apikey']);
    }
  } catch (Exception $e) {
    $status = array(
      'code' => 0,
      'error' => $e->getMessage(),
    );
  }

  return array($mollie, $status);
}

function cot_molliebilling_payment($mollie, $pid = 0, $summ = 0, $desc = '') {
  global $cfg;

  $status = array(
    'code' => 1,
    'error' => '',
  );
  $payment = null;
  $profile = null;
  $paydata = array(
              "amount" => array(
                 "currency" => $cfg['plugin']['molliebilling']['valuta'],
                 "value" => cot_molliebilling_summ($summ)
              ),
              "description" => $desc,
              "redirectUrl" => COT_ABSOLUTE_URL . cot_url('plug', 'e=molliebilling&m=status&pid='.$pid, '', true),
              "webhookUrl"  => COT_ABSOLUTE_URL . cot_url('plug', 'r=molliebilling&pid='.$pid, '', true),
              "metadata" => array(
                "order_id" => $pid,
              ),
            );

  try {
    if($cfg['plugin']['molliebilling']['apitype'] == 'AccessToken') {
      $profiles = $mollie->profiles->page();
      $profile  = reset($profiles);

      $paydata['profileId'] = $profile->id;
    }

    $payment = $mollie->payments->create($paydata);
  } catch (Exception $e) {
    $status = array(
      'code' => 0,
      'error' => $e->getMessage(),
    );
  }

  return array($payment, $status);
}
