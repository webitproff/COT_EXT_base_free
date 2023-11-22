<?php
/* ====================
[BEGIN_COT_EXT]
Code=smsru
Name=SMS.ru
Category=security-authentication
Description=API сервиса sms.ru
Version=1.0.0
Date=2014-May-07
Author=Andrey Matsovkin
Copyright=Copyright (c) 2011-2014, Andrey Matsovkin
Notes=
Auth_guests=R1
Lock_guests=W2345A
Auth_members=RW1
Lock_members=2345
Recommends_modules=
Recommends_plugins=
Requires_modules=
Requires_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
authtype=01:select:0,1,2:0:Auth method
api_id=02:string::5C764026-B4A2-896E-9E12-87C536760B94:API ID
login=03:string:::Login
password=04:string:::Password
sendername=05:callback:smsru_sendernames():PilotHUB:Sender name
testnumber=06:string:::Testing number
testmode=07:radio::0:Enable test mode
testauth=08:custom:smsru_check_auth():def_value:Test user login/password for auth
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL.');