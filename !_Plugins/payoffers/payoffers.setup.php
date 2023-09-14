<?php
/** ====================
 * [BEGIN_COT_EXT]
 * Code=payoffers
 * Name=Коммисия за предложения по проектам
 * Version=1.0.1
 * Author=Alexeev Vlad
 * Copyright=Copyright (c) cotontidev.ru
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW1
 * Lock_members=2345A
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * offerpaytype=01:select:fixed,percent:fixed:Тип комиссии
 * offerpaycostpercent=02:string::5:Размер комиссии в %
 * offerpaycostfixed=03:string::120:Размер комиссии в валюте сайта
 * offercancelrefund=04:radio::0:Возвращать комиссию за предложение при отказе или выборе другого исполнителя
 * [END_COT_EXT_CONFIG]
 * ==================== */


defined('COT_CODE') or die('Wrong URL');
