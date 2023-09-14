<?php
defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_codes'] = array('Список платежек', '');

$L['easypaygroup_admin_config_group'] = 'Группа <small>(в которую попадет пользователь после оплаты)</small>';
$L['easypaygroup_admin_config_name'] = 'Название';
$L['easypaygroup_admin_config_time'] = 'Срок применения новой группы';
$L['easypaygroup_admin_config_cost'] = 'Стоимость';

$L['easypaygroup_buy_title'] = 'Оформление платежа';

$L['easypaygroup_time'] = 'Время нахождения в группе';
$L['easypaygroup_cost'] = 'Сумма к оплате';
$L['easypaygroup_email'] = 'Email';
$L['easypaygroup_buy'] = 'Оплатить';

$L['easypaygroup_email_paid_admin_subject'] = 'Информация об оплате';
$L['easypaygroup_email_paid_admin_body'] = 'Здравствуйте,

Пользователь %1$s произвел оплату на сайте.

Подробная информация:

Наименование: %2$s
Стоимость: %3$s
Номер платежа: %4$s
Дата оплаты: %5$s.

';

$L['easypaygroup_email_paid_customer_subject'] = 'Информация об оплате';
$L['easypaygroup_email_paid_customer_body'] = 'Здравствуйте, %1$s,

Благодарим вас за оплату!

Подробная информация:

Наименование: %2$s
Стоимость: %3$s
Номер платежа: %4$s
Дата оплаты: %5$s.

';

$L['easypaygroup_email_paid_guest_subject'] = 'Информация об оплате';
$L['easypaygroup_email_paid_guest_body'] = 'Здравствуйте, %1$s,

Благодарим вас за оплату, Вы успешно зарегистрированы!

Подробная информация:

Наименование: %2$s
Стоимость: %3$s
Номер платежа: %4$s
Дата оплаты: %5$s.

Ваш логин: %6$s.
Пароль: %7$s.

';