<?php defined('COT_CODE') or die('Wrong URL');
/*
 * Russian langfile for amarket
 */


/*
 * Meta & configuration
 */
$L['info_name'] = 'Дополнительный маркет';
$L['info_desc'] = 'Расширение возможностей модуля Market';

$L['cfg_am_custumer_id'] = array("Основная группа покупателя","ID основной группы для покупателя (#7)");
$L['cfg_am_seller_id'] = array("Основная группа продавца","ID основной группы для продавца (#4)");
$L['cfg_am_from_customer'] = array("Комиссия с покупателя","Процент который будет снят с суммы предназначеной для зачислений покупателю");
$L['cfg_am_from_seller'] = array("Комиссия с продавца","Процент который будет снят с суммы предназначеной для зачислений продавцу");
$L['cfg_am_maxperpage'] = array("Елементов на страницу","Во всех разделах плагина");
$L['cfg_am_enablenotif'] = array("Включить уведомления","Уведомлять стороны об изменениях статуса заказа");
$L['cfg_am_enablereason'] = array("Указывать причину отказа","При отказе оплаты или подверждения заказа необходимо указывать причину");

/*
 * Main strings
 */
$L['amarket_title'] = 'Заказы';
$L['amarket_mysales_title'] = 'Мои продажи';
$L['amarket_myorders_title'] = 'Мои заказы';
$L['amarket_pay_title'] = 'Оплата заказа';
$L['amarket_list.edit_title'] = 'Редактирование списка товаров';
$L['amarket_list.seller_title'] = 'Список товаров';
$L["amarket_cancel_title"] = 'Причина отмены заказа';

$L['amarket_status_forconfirm_title'] = 'Заявки на подтверждение'; // 1
$L['amarket_status_forpayment_title'] = 'Заявки на оплату'; // 2
$L['amarket_status_waitpayment_title'] = 'Ожидают оплату'; // 2
$L['amarket_status_paid_title'] = 'Оплаченные заказы'; // 3
$L['amarket_status_cancelled_title'] = 'Отмененные заказы'; // 4
$L['amarket_status_edit_title'] = 'Редактирование'; // For title


$L['Changed'] = 'Изменено';
$L['Customer'] = 'Покупатель';
$L['Seller'] = 'Продавец';
$L['Products'] = 'Товары';
$L['Product'] = 'Товар';
$L['Cost'] = 'Стоимость';
$L['Cost_all'] = 'Общая стоимость';
$L['Pay_off'] = 'К выплате';
$L['To_pay'] = 'К оплате';
$L['Cancel_order'] = 'Отменить';
$L['Clear_order'] = 'Удалить заказ';
$L['Clear_order_all'] = 'Удалить все заказы';
$L['Confirm_order'] = 'Подтвердить';
$L['Pay_order'] = 'Оплатить';
$L['Commission'] = 'Комиссия составляет';
$L['Edit_prd_list'] = 'Редактировать список';
$L['amarket_list_for'] = 'Список товаров для';
$L['amarket_update_count'] = 'Обновленно {$count} товаров';
$L['amarket_update_extfld'] = 'Обновленны дополнительные условия';
$L['amarket_myproducts'] = 'Список моих товаров';
$L['amarket_header_waitpayment_title'] = 'К оплате ';
$L['amarket_header_forconfirm_title'] = 'На утверждение ';
$L['amarket_cancel_reason'] = 'Опишите причину отказа по заявке, это поможет в будущем исправить недочеты!';
$Ls['amarket_header_declension'] = 'заявка, заявки, заявок';
$Ls['amarket_prds_declension'] = 'товар, товара, товаров';
/*
 * Messages
 */
$L['amarket_change_status_succses'] = "Статус изменен успешно! Заявка отправленна покупателю для оплаты.";
$L['amarket_change_status_hidden'] = "Заявка удалена успешно";
$L['amarket_change_status_error'] = "Ошибка, статус не изменен!";
$L['amarket_cancel_reason_short'] = "Текст причины отказа по заявке слишком короткий";
$L['amarket_change_status_warning'] = "Заказ отменен, статус изменен успешно!";
$L['amarket_err_delete_prd'] = "Нельзя удалить товар если он один в списке!";
$L['amarket_err_delete_prd_ukn'] = "Товар не удален, обратитесь к администрации и сообщите порядок действий которые привели к появлению ошибки";

$L['amarket_err_prdnotfound'] = "Список товаров пуст для формирования заказа";

$L['amarket_pay_desc'] = 'Оплата заказа #{$id}';

/*
*Mail stirng
*/

$L['amarket_mail_addorder_titile'] = 'Добавлен новый заказ';
$L['amarket_mail_addorder_body'] = 'Добрый день, пользователь {$user} добавил новый заказ, перейдите на сайт ({$link}) и подтвердите наличие товара.';

$L['amarket_mail_cancel_titile'] = 'Заказ отменен';
$L['amarket_mail_cancel_body'] = 'Добрый день, пользователь {$user} отменил заказ #{$id}. {$link}';

$L['amarket_mail_confirm_titile'] = 'Подтверждение заказа';
$L['amarket_mail_confirm_body'] = 'Добрый день, пользователь {$user} подтвердил заказ #{$id}. Проверьте комплектацию и оплатите заказ. {$link}';

$L['amarket_mail_pay_titile'] = 'Оплата по заказу';
$L['amarket_mail_pay_body'] = 'Добрый день, пользователь {$user} оплатил заказ #{$id}. {$link}';
