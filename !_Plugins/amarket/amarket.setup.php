<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Code=amarket
Name=Adv market
Description=
Version=1.2.0
Date=2016-02-10
Author=CrazyFreeMan
Copyright=&copy; CrazyFreeMan, 2016
Notes=
Auth_guests=R
Lock_guests=2345A
Auth_members=RW
Lock_members=2345
Requires_modules=market,users,payments
Requires_plugins=
Recommends_modules=
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
am_custumer_id=01:string:7:7:Покупатель
am_seller_id=02:string:4:4:Продавец
am_from_customer=03:string:5:5:Процент с покупателя
am_from_seller=04:string:5:5:Процент с продавца
am_maxperpage=05:select:5,15,30,50,75,100:15:Елементов на страницу
am_enablenotif=06:radio::1:Включить уведомления пользователям
am_enablereason=07:radio::1:При отказе указывать причину
[END_COT_EXT_CONFIG]
==================== */
