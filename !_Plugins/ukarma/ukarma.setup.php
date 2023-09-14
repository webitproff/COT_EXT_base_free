<?php
/* ====================
[BEGIN_COT_EXT]
 * Code=ukarma
 * Name=Ukarma
 * Category=community-social
 * Description=Universal karma plugin by CMSWorks.ru
 * Version=1.0.5
 * Date=2013-09-30
 * Author=CMSWorks Team
 * Copyright=Copyright (c) CMSWorks.ru
 * Notes=BSD License
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
karma_rate=01:string::5:Минимальная карма для влияния на карму других пользователей (>=)
karma_addtopic=02:string::null:Минимальная карма для создания новых тем на форуме (null - не учитывать)
karma_addpost=03:string::null:Минимальная карма для создания новых постов на форуме (null - не учитывать)
karma_daylimit=04:string::0:Количество оценок в сутки
karma_personaldaylimit=05:string::0:Количество оценок в сутки одному пользователю
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

