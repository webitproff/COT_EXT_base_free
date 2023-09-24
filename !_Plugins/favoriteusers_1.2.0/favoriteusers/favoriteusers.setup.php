<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Code=favoriteusers
Name=Favorite users
Description=List of favorite users
Version=1.2.0
Date=2015-12-29
Author=CrazyFreeMan
Copyright=&copy; CrazyFreeMan (www.simple-website.in.ua), 2015
Notes=
Auth_guests=R
Lock_guests=2345A
Auth_members=RW
Lock_members=2345
Requires_modules=users
Requires_plugins=
Recommends_modules=
Recommends_plugins=paypro,autocomplete,usercategories,userpoints
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
favu_maxperpage=01:select:5,10,15,30,50,75,100:15:
favu_limitperuser=02:string:10:10
[END_COT_EXT_CONFIG]
==================== */

/**
 * favorite users plugin
 *
 * @package favoriteusers
 * @version 1.2.0
 * @author CrazyFreeMan (www.simple-website.in.ua)
 * @copyright Copyright (c) CrazyFreeMan (www.simple-website.in.ua)
 */