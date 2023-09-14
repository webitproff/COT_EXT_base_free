<?php
/* ====================
[BEGIN_COT_EXT]
Code=sendfieldstomail
Name=Отправка писем с данными страницы
Category=
Description=для модулей Page и Market
Version=1.0.0
Date=26.04.2017
Author=Alexeev Vlad
Copyright=Cotontidev.ru
Notes=BSD License
SQL=
Auth_guests=RW
Lock_guests=12345A
Auth_members=RW
Lock_members=12345A
Requires_modules=page,market
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
sftm_emails=01:string:::Почтовые адреса для отправки новых страниц page и market
sftm_page_field=02:string:::PAGE - Код экстраполя для отправки пользователю
sftm_market_field=3:string:::MARKET - Код экстраполя для отправки пользователю
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

?>
