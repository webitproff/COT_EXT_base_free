<?php defined('COT_CODE') or die('Wrong URL');
/*
 * Russian langfile for po
 */


/*
 * Meta & configuration
 */
$L['info_name'] 					= 'Купить "Предложения"';
$L['name']							= &$L['info_name'];
$L['info_desc'] 					= 'Покупка "Предложений по проектам" для фрилансеров';

$L['cfg_po_config'] 				= array('Тарифная сетка','Один тариф в одной строке<br>В формате:<br>code|10|5<br>Где code = уникальный код тарифа, 10 - количество, 5 - стоимость');
$L['cfg_po_pro_discount']			= array('Скидка % для PRO','Работает если включен PayPro <br>0 - отключено');
$L['cfg_po_offerslimit']			= array('Лимит бесплатных предложений','Количество бесплатных предложений в день для всех пользователей<br>0 - отключено (нет бесплатных)');
$L['cfg_po_separator']				= 'Настройка администрирования';
$L['cfg_po_admin_maxperpage']		= array('Пользователей на страницу','Количество пользователей на одной странице в Администрировании');

/*
 * Main strings
 */
$L['po_title'] 						= 'Купить "Предложения"';

$L['po_user_offercount']			= 'Купить "Предложения"';
$L['po_user_offercount_available'] 	= 'Предложений';
$L['po_user_offercount_title'] 		= 'Доступно';

$L['po_pay_desc']					= 'Покупка "Предложений" {$count} шт';
$L['po_form_countleft']				= 'Вы можете оставить {$countleft} предложений';
$L['po_addoffer_countleft']			= 'Лимит на публикацию составляет: {$countleft} предложений';
$L['po_addoffer_freecountleft']		= 'Сегодня осталось бесплатных: {$countleft} предложений';

/*
 * Messages
 */
$L['po_error_code'] 				= 'Отсутствует или неверно указан код тарифа';
$L['po_error_user'] 				= 'Пользователь не найден';
$L['po_error_tariff'] 				= 'Тариф не найден';
$L['po_error_limit_empty'] 			= 'Лимит на публикацию предложений исчерпан. <a target="_blank" href="{$url}">'.$L["po_title"] .'</a>';

$L['po_err_userfound']				= 'Пользователь не найден';
$L['po_err_userofferlimit']			= 'Лимит не может быть меньше 0';
$L['po_err_update']					= 'Лимит не установлен, обратитесь к разработчику';
$L['po_adm_username']				= 'Никнейм пользователя';
$L['po_adm_userofferlimit']			= 'Лимит предложений пользователя';
$L['po_adm_limitoffer']				= 'Лимит пользователя:';

$L['msg920_title']					= 'Подтверждение покупки предложений';
$L['po_pay_confirm']				= 'Вы действительно хотите купить предложения';