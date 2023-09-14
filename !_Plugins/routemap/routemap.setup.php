<?php
/* ====================
[BEGIN_COT_EXT]
Code=routemap
Name=Карта с маршрутом для проектов
Version=1.1.0
Author=Alexeev Vlad
Auth_guests=R
Lock_guests=2345A
Auth_members=RW1
Lock_members=
Requires_plugins=projects
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
mapservice=01:select:yandex,google:yandex:API карт
apikey_ynd=02:string:::Yandex Map API key
apikey=03:string:::Google Map API key
rmscroll=04:radio::0:Запретить маштабирование карты колесиком мыши
rmicon=05:hidden:::Ссылка на свою иконку метки, если пусто - будет стандартная метка
[END_COT_EXT_CONFIG]
==================== */

/**
 * Route for projects (google maps)
 * @Version 1.1.0
 * @package routemap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');
