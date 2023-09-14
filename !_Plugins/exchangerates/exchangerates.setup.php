<?php

/**
 * [BEGIN_COT_EXT]
 * Code=exchangerates
 * Name=Курсы валют
 * Category=Payments
 * Description=Курсы валют
 * Version=1.0.0
 * Date=15.01.2020
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
 * upd=01:custom:cot_exchangerates_cfg_upd():3600:Частота обновления
 * base=02:custom:cot_exchangerates_cfg_base():USD:Базовая валюта (курс валют по отношению к этой валюте)
 * rates=03:custom:cot_exchangerates_cfg_rates()::Курсы валют (по отношению к базовой валюте)
 * [END_COT_EXT_CONFIG]
 */

?>