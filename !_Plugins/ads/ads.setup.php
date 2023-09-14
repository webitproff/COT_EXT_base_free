<?php
/* ====================
[BEGIN_COT_EXT]
Code=ads
Name=Рекламные объявления
Version=1.0.0
Date=16.03.2016
Author=Alexeev Vlad
Copyright=cotontidev.ru
Notes=
Auth_guests=R
Lock_guests=W12345A
Auth_members=RW
Lock_members=A
Requires_modules=payments,users
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
purchase_period=01:select:day,week,month:week:Период для покупки (День,неделя,месяц)
[END_COT_EXT_CONFIG]

[BEGIN_COT_EXT_CONFIG_STRUCTURE]
price=01:string::100:Цена за период (В валюте сайта)
[END_COT_EXT_CONFIG_STRUCTURE]
  ==================== */
defined('COT_CODE') or die('Wrong URL.');

