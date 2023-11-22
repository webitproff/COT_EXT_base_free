<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Code=sms
 * Name=SMS Router
 * Category=security-authentication
 * Description=Выбор sms-сервиса
 * Version=1.0.2
 * Date=
 * Author=Bulat Yusupov (http://cmsworks.ru)
 * Copyright=&copy; CMSWorks Team 2014
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=W12345A
 * Requires_modules=
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * api=01:select:smsru,smsaero,testapi:smsru:SMS API
 * attemptslimit=02:string::9999:Число попыток в сутки
 * attemptstimeout=03:string::180:Период следующей попытки
 * [END_COT_EXT_CONFIG]
 */

defined('COT_CODE') or die('Wrong URL.');