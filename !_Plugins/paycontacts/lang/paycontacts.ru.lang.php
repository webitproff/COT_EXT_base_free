<?php
defined('COT_CODE') or die('Wrong URL.');

$L['cfg_cost'] = array('Стоимость в месяц', '');
$L['cfg_extra'] = array('Укажите экстраполя которые будут доступны после подписки в теге {_CONTACTS_SHOW}', '');

$L['info_desc'] = 'Подписка на просмотр контактов';

$L['paypaycontacts_buy_title'] = 'Покупка подписки на просмотр контактов';
$L['paypaycontacts_buy_paydesc'] = 'Покупка подписки на просмотр контактов';
$L['paypaycontacts_costofmonth'] = 'Стоимость за месяц';
$L['paypaycontacts_error_months'] = 'Укажите срок действия услуги';

$L['paypaycontacts_buy'] = 'Купить';
$L['paypaycontacts_month'] = 'месяц';

$L['paypaycontacts_header_buy'] = 'Купить подписку на просмотр контактов';
$L['paypaycontacts_header_expire'] = 'Подписка действует до';
$L['paypaycontacts_header_expire_short'] = 'Подписка до';
$L['paypaycontacts_header_extend'] = 'Продлить подписку';

$L['paypaycontacts_error_monthsempty'] = 'Срок действия услуги не указан';

$L['paypaycontacts_buy_tag'] = '<a href="'. COT_ABSOLUTE_URL . cot_url('plug', 'e=paycontacts').'">Для просмотра контактов нужна подписка</a>';
$L['paypaycontacts_buy_user_tag'] = 'К сожалению у пользователя не активирована подписка, вы не можете посмотреть его контакты';

$L['paypaycontacts_mail_title_admin'] = 'Новая покупка подписки на контакты';
$L['paypaycontacts_mail_buy_title_user'] = 'Подписка активирована';

$L['paypaycontacts_mail_buy_user'] = 'Здравствуйте, {$user_name}. '."\n\n".'Подписка на просмотр контактов успешно активирована.';
$L['paypaycontacts_mail_buy_admin'] = 'Пользователь {$user_name}. успшно оплатил подписку на просмотр контактов';

$L['paypaycontacts_mail_remind_title'] = 'Подписка на контакты';
$L['paypaycontacts_mail_remind'] = 'Осталось {$days} дней до окончания подписки. '."\n\n".' Рекомендуем Вам <a href="'. COT_ABSOLUTE_URL . cot_url('plug', 'e=paycontacts').'">Продлить подписку</a>.';