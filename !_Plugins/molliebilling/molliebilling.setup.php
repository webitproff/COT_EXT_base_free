<?php

/**
 * [BEGIN_COT_EXT]
 * Code=molliebilling
 * Name=mollie billing
 * Category=Payments
 * Description=mollie.com billing system
 * Version=1.0.1
 * Date=03.10.2019
 * Author=Alexeev Vlad
 * Copyright=&copy; cotontidev.ru
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=payments
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * apitype=01:select:ApiKey,AccessToken::AUTH TYPE
 * apikey=02:string::test_p3jsvbTSE2A4vPQMEcBKU5kSURSbJu:API KEY (test_* or live_* for ApiKey && access_* for AccessToken)
 * valuta=03:custom:cot_molliebilling_cfg_valuta():EUR:VALUTA
 * rate=04:string::1:The ratio of the amount to the currency
 * paydesc=05:text::{$pay_desc}:Описание платежа, можно использовать теги
 * [END_COT_EXT_CONFIG]
 */

?>