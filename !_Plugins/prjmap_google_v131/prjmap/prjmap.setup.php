<?php
/* ====================
[BEGIN_COT_EXT]
Code=prjmap
Name=Projects on google maps
Version=1.3.1
Author=Alexeev Vlad
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Requires_plugins=projects,locationselector
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
apikey=01:string:::Google Map API key
indexlimit=02:string::30:Число проектов на карте
center=03:string::Москва:Карту какого города отображать на общей карте
mapscroll=04:radio::0:Запретить маштабирование карты колесиком мыши
disableui=05:radio::0:Скрыть UI на карте
icon=06:string:::Ссылка на свою иконку метки, если пусто - будет стандартная метка
zoom=07:select:10,11,12,13,14,15,16:13:Зум карты в проекте
zoomindex=08:select:10,11,12,13,14,15,16:13:Зум карты на главной
type=09:select:1,2,3,4:1:
[END_COT_EXT_CONFIG]
==================== */

/**
 * Projects on google maps
 * @Version 1.2
 * @package prjmap
 * @copyright (c) Alexeev Vlad
 */

defined('COT_CODE') or die('Wrong URL');
