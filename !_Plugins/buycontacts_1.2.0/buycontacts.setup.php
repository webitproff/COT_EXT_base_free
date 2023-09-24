<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Code=buycontacts
Name=Buy contacts
Description=Buy employer contacts
Version=1.1.0
Date=2015-07-02
Author=CrazyFreeMan
Copyright=&copy; CrazyFreeMan, 2015
Notes=Use {PRJ_ID|cot_contact_isbought($this)} for check 
Auth_guests=R
Lock_guests=2345A
Auth_members=RW
Lock_members=2345
Requires_modules=projects,users,payments
Requires_plugins=
Recommends_modules=
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
bc_fromcost=01:callback:cot_contact_fromcost()
bc_ispercent=02:radio:0,1:1:
bc_formula_performer=03:textarea::100|200|5
bc_formula_def=04:string::30
bc_mincost=05:string::300
[END_COT_EXT_CONFIG]
==================== */