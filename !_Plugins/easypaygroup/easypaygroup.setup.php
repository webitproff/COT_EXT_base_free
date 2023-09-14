<?php
/**
 * [BEGIN_COT_EXT]
 * Code=easypaygroup
 * Name=Easy Pay Group
 * Category=Payments
 * Description=Плагин для платного перехода в группу
 * Version=1.0.0
 * Date=
 * Author=Alexeev Vlad
 * Copyright=Copyright (c) cotontidev.ru
 * Notes=
 * Auth_guests=RW
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=users,payments
 * Requires_plugins=
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * codes=01:textarea::4|Стать фрилансером|30|0:Format settings group|name|time(in days)|cost
 * defaultgroup=02:string::7:Номер группы для перехода пользователя по окончанию действия услуги
 * autologin=03:string::1:Переадресация на страницу авторизации после оплаты (0 - нет, 1 - да)
 * [END_COT_EXT_CONFIG]
 */
?>