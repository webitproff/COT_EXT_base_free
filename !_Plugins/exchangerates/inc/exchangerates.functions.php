<?php

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('exchangerates', 'plug');

global $exchangerates_currency;
$exchangerates_currency = array("CAD", "HKD", "ISK", "PHP", "DKK", "HUF", "CZK", "AUD", "RON", "SEK", "IDR", "INR", "BRL", "RUB", "HRK", "JPY", "THB", "CHF", "SGD", "PLN", "BGN", "TRY", "CNY", "NOK", "NZD", "ZAR", "USD", "MXN", "ILS", "GBP", "KRW", "MYR");

function cot_exchangerates_curl($url = '') {

  $return = array();

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
  curl_setopt($ch, CURLOPT_POST, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);

  if(count($headers) > 0) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $content = curl_exec($ch);

  if (!curl_errno($ch)) {
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpcode == 302) {
      $httpinfo = curl_getinfo($ch);
      if(!empty($httpinfo['redirect_url'])) return cot_cryptoniq_curl($httpinfo['redirect_url']);
    } elseif($httpcode == 503) {
      $content = '';
    }

    $return = (!empty($content) ? json_decode( $content, true ) : array());
    if(!is_array($return)) $return = array();
  } else {
    $content = array();
  }

  curl_close($ch);

	return $return;
}

function cot_exchangerates_get_currency_prices($base_currency = '', $nocache = false) {
  global $cfg, $cache;

  if(empty($base_currency)) $base_currency = $cfg['plugin']['exchangerates']['base'];
  if(empty($base_currency)) $base_currency = 'EUR';

  $exchangerates_currency_prices = array();

  if (!$nocache && $cache) {
    $cache_type = $cache->mem;
    if(!$cache_type) $cache_type = $cache->db;

    if($cache_type && $cache_type->exists('exchangerates_currency_prices_'.$base_currency, 'system')) {
      $exchangerates_currency_prices = $cache_type->get('exchangerates_currency_prices_'.$base_currency, 'system');
    }
  }

  if(!count($exchangerates_currency_prices)) {
    $url = 'https://api.exchangeratesapi.io/latest?base=' . $base_currency;
    $exchangerates_curl = cot_exchangerates_curl($url);

    if(is_array($exchangerates_curl['rates']) && count($exchangerates_curl['rates']) > 0) {
      foreach($exchangerates_curl['rates'] as $k => $v) {
        $exchangerates_currency_prices[$k] = $exchangerates_curl['rates'][$k];
      }
    }

    if(!$cfg['plugin']['exchangerates']['upd']) $cfg['plugin']['exchangerates']['upd'] = 3600;
    if(count($exchangerates_currency_prices) > 0 && $cache && $cache_type) $cache_type->store('exchangerates_currency_prices_'.$base_currency, $exchangerates_currency_prices, 'system', (int)$cfg['plugin']['exchangerates']['upd']);
  }

  return $exchangerates_currency_prices;
}

function cot_exchangerates_cfg_upd($name, $value) {
  global $cfg, $L;

  if(is_array($name)) {
    $value = $name['config_value'];
    $name = $name['config_name'];
  }

  $return = '<select name="'.$name.'"/>';
    foreach(array(3600, 7200, 10800, 21600, 43200) as $k) {
      $return .= '<option value="'.$k.'"'.($value == $k ? ' selected="selected"' : '').'>'. $L['exchangerates_cfg_upd_' . $k] . '</option>';
    }
  $return .= '</select/>';

  return $return;
}

function cot_exchangerates_cfg_base($name, $value) {
  global $cfg, $exchangerates_currency;

  if(is_array($name)) {
    $value = $name['config_value'];
    $name = $name['config_name'];
  }

  $return = '<select name="'.$name.'"/>';
    foreach($exchangerates_currency as $k) {
      $return .= '<option value="'.$k.'"'.($value == $k ? ' selected="selected"' : '').'>'. $k . '</option>';
    }
  $return .= '</select/>';

  return $return;
}

function cot_exchangerates_cfg_rates($name, $value) {
  global $cfg, $L;

  if(is_array($name)) {
    $value = $name['config_value'];
    $name = $name['config_name'];
  }

  $rates = cot_exchangerates_get_currency_prices('', true);

  $return = '<textarea id="exchangerates_cfg_rates" name="'.$name.'" style="display: none;">'.$value.'</textarea>';

  $return .= '<table>';
    foreach($rates as $k => $v) {
      $return .= '<tr><td>'.$k.'</td><td>'.$v.'</td></td>';
    }
  $return .= '</table>';

  return $return;
}

function cot_exchangerates_get($cur = '', $base_currency = '', $format = 0) {
  $rates = array();
  if(!empty($cur)) $rates = cot_exchangerates_get_currency_prices($base_currency);

  return ((!empty($cur) && is_array($rates) && $rates[$cur]) ? ($format > 0 ? number_format( (float) $rates[$cur], $format, '.', '' ) : $rates[$cur]) : 0);
}