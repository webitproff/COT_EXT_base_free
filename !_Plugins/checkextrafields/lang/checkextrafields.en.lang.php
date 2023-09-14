<?php
defined('COT_CODE') or die('Wrong URL.');

$L['checkextrafields_default'] = "Заполните поле "; //Дописывается название поля

$L['checkextrafields_page_files'] = "Загрузите файлы";
$L['checkextrafields_page_mavatars'] = "Загрузите файлы";

$L['checkextrafields_market_files'] = "Загрузите файлы";
$L['checkextrafields_market_mavatars'] = "Загрузите файлы";

$L['checkextrafields_projects_files'] = "Загрузите файлы";
$L['checkextrafields_projects_mavatars'] = "Загрузите файлы";

$L['checkextrafields_demands_files'] = "Загрузите файлы";
$L['checkextrafields_demands_mavatars'] = "Загрузите файлы";

/*
 К примеру если требуется кастомное сообщение о том что необходимо заполнить поле, то следующий принцип.
 К примеру для модуля PAGE есть экстраполе с кодом myfield, тогда дописываем в этот файл
 $L['checkextrafields_page_myfield'] = 'Заполните поле myfield иначе котики будут грустить';
*/