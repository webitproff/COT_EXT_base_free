<?php
/**
 * [BEGIN_COT_EXT]
 * Code=reviewstar
 * Name=Review Star Rating
 * Description=Дополнение для плагина отзывов. Рейтинг пользователя в виде звезд на основе отзывов.
 * Version=1.0.1
 * Date=23.01.2016
 * Author=Alexeev Vlad
 * Copyright=Copyright (c) cotontidev.ru
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=projects
 * Requires_plugins=reviews
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * autocountrate=01:radio::1:Автоматически считать оценку отзыва? (Положительный - если средняя оценка по 3-ем критериям больше 2.5)
 * type_a=02:string::Вежливость:Название 1-го критерия
 * type_b=03:string::Адекватность:Название 2-го критерия
 * type_c=04:string::Оперативность:Название 3-го критерия
 * [END_COT_EXT_CONFIG]
 */

defined('COT_CODE') or die('Wrong URL');

?>