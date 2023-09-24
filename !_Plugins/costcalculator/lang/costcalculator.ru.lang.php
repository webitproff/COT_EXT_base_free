<?php defined('COT_CODE') or die('Wrong URL');
/*
 * Russian langfile for costcalc
 */


/*
 * Meta & configuration
 */
$L['info_name'] = $L['costcalc_title'] = $L['costcalc'] = 'Калькулятор стоимости';
$L['info_desc'] =  'Расчет стоимости услуг';
$L['costcalc_desc'] = 'Расчет стоимости различных услуг на основании прайс-листов заполеннными исполнителями на нашем сайте';
$L['cc_keywords'] = 'калькулятор, стоимость, рассчитать';

$L['cfg_cc_allowtosave'] = array('Разрешить сохранять расчеты','Разрешать авторизованным пользователя сохранять расчеты');
$L['cfg_cc_savetime'] = array('Сохранять дней','Сколько дней будет хранится сохраненный расчет пользователя');
$L['cfg_cc_rowsperpage'] = array('Калькуляторов на странице','Количество калькуляторов на одной странице');
$L['cfg_cc_currency'] = array('Валюта');
$L['cfg_cc_count_users'] = array('Количество результатов', 'Количество пользователей в результатах рассчетов');


/*
 * Main strings
 */

/*
 * admin Main strings
 */
$L['cc_newcalc'] = 'Добавить - редактировать калькулятор';
$L['cc_configcalc'] = 'Добавить - редактировать поля';

$L['cc_title'] = 'Название';
$L['cc_desc'] = 'Описание';
$L['cc_rownum']= 'Количество полей';
$L['cc_allowgroups'] = 'Доступно группам';
$L['cc_actions'] = 'Действия';
$L['cc_units'] = 'Единица измерения';
$L['cc_calculate'] = 'Рассчитать';

$L['cc_updatedon'] = 'Цены актуальны на';
$L['cc_summ'] = 'Общая сумма:';

$L['cc_fill_calculate'] = 'Заполнить калькулятор';
$L['cc_listof_users'] = 'Список специалистов заполнивших калькулятор:';
$Ls['cc_specialiss'] ='специалист,специалиста,специалистов';
/*
 * Messages
 */
$L['cc_err_empty_name'] = 'Название не может быть пустым';
$L['cc_err_empty_units'] = 'Единица измерения не может быть пустой';

$L['cc_err_empty_row'] = '<div class="alert alert-danger">Все поля обязательны к заполнению (не допустимо значение меньше или равно 0 и пусто. Проверьте следующие поля: {$rows}</div>';
$L['cc_err_clean_calc'] = 'Ошибка удаления значений калькулятора'; 
$L['cc_succ_clean_calc'] = 'Значения калькулятора очищены'; 