<?php
/**
 * [BEGIN_COT_EXT]
 * Code=timeline
 * Name=TimeLine
 * Description=История активности пользователей в виде timeline
 * Version=1.2
 * Date=18.03.2016
 * Author=Alexeev Vlad http://cmsworks.ru/users/alexvlad
 * Copyright=Copyright (c) cotontidev.ru
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_plugins=userpoints
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * indexlimit=01:string::5:Кол-во записей на главной
 * folio_add=02:select:all,main,details,none:all:Добавление работы в портфолио
 * forums_newtopic=03:select:all,main,details,none:all:Создание нового топика на форуме
 * forums_newforumpost=04:select:all,main,details,none:all:Создание нового сообщения на форуме
 * market_add=04:select:all,main,details,none:all:Добавление нового товара
 * users_register=05:select:all,main,details,none:all:Успешная регистрация пользователя
 * projects_add=06:select:all,main,details,none:all:Добавление нового проекта
 * projects_offers_add=07:select:all,main,details,none:all:Добавление нового предложения по проекту
 * projects_offers_performer=08:select:all,main,details,none:all:Выбор исполнителя по проекту (для исполнителя)
 * projects_offers_setperformer=09:select:all,main,details,none:all:Выбор исполнителя по проекту (для заказчика)
 * projects_offers_refuse=10:select:all,main,details,none:details:Получил отказ по проекту (для исполнителя)
 * payprjbold_done=11:select:all,main,details,none:all:Платное выделение проекта
 * payprjtop_done=12:select:all,main,details,none:all:Платное поднятие проекта
 * paypro_done=13:select:all,main,details,none:all:Покупка PRO-аккаунта
 * paytop_done=14:select:all,main,details,none:all:Покупка места на главной
 * reviews_add=15:select:all,main,details,none:all:Добавление отзыва (для заказчика)
 * reviews_give=16:select:all,main,details,none:details:Получение отзыва (для исполнителя)
 * [END_COT_EXT_CONFIG]
 */

/** 
   
  Разработка сайтов на cotonti, готовые плагины - cotontidev.ru
   
**/

defined('COT_CODE') or die('Wrong URL');

?>