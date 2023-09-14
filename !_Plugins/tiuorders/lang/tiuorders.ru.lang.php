<?php

/**
 * tiuorders plugin
 *
 * @package tiuorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_warranty'] = array('Гарантийный срок (дней)');
$L['cfg_tax'] = array('Комиссия за продажи (%)');
$L['cfg_ordersperpage'] = array('Число заказов на странице');

$L['tiuorders'] = 'Заказы в магазине';

$L['tiuorders_admin_home_all'] = 'Все заказы';
$L['tiuorders_admin_home_claims'] = 'Проблемные заказы';
$L['tiuorders_admin_home_done'] = 'Исполненные заказы';
$L['tiuorders_admin_home_cancel'] = 'Отмененные заказы';

$L['tiuorders_mysales'] = 'Мои продажи';
$L['tiuorders_mypurchases'] = 'Мои покупки';

$L['tiuorders_sales_title'] = 'Мои продажи';
$L['tiuorders_purchases_title'] = 'Мои покупки';
$L['tiuorders_empty'] = 'Заказов нет';

$L['tiuorders_neworder_button'] = 'Купить сейчас';
$L['tiuorders_neworder_title'] = 'Оформление заказа';
$L['tiuorders_neworder_product'] = 'Наименование товара';
$L['tiuorders_neworder_count'] = 'Количество';
$L['tiuorders_neworder_comment'] = 'Комментарий к заказу';
$L['tiuorders_neworder_total'] = 'Итого к оплате';
$L['tiuorders_neworder_email'] = 'Email';

$L['tiuorders_neworder_error_count'] = 'Не указано количество';
$L['tiuorders_order_error_claimtext'] = 'Не заполнен текст жалобы';

$L['tiuorders_title'] = 'Информация о заказе';
$L['tiuorders_product'] = 'Наименование товара';
$L['tiuorders_count'] = 'Количество';
$L['tiuorders_comment'] = 'Комментарий к заказу';
$L['tiuorders_cost'] = 'Сумма заказа';
$L['tiuorders_paid'] = 'Дата оплаты';
$L['tiuorders_warranty'] = 'Гарантийный срок';

$L['tiuorders_done_payments_desc'] = 'Выплата по заказу № {$order_id} ({$product_title})';

$L['tiuorders_paid_mail_toseller_header'] = 'Новый заказ № {$order_id} ({$product_title})';
$L['tiuorders_paid_mail_toseller_body'] = 'Поздравляем! Пользователь {$user_name}, оформил и оплатил заказ № {$order_id} ([{$product_id}] {$product_title}). Если у покупателя не будет претензий к приобретенному товару/услуге, то по истечению гарантийного срока ({$warranty} дней) на ваш счет поступит оплата в размере {$summ} с учетом комиссии сервиса {$tax}%. Подробности заказа смотрите по ссылке:  {$link}';

$L['tiuorders_paid_mail_tocustomer_header'] = 'Заказ № {$order_id} оплачен';
$L['tiuorders_paid_mail_tocustomer_body'] = 'Поздравляем! Вы оплатили заказ № {$order_id} ([{$product_id}] {$product_title}) на сумму {$cost}. Подробности заказа смотрите по ссылке:  {$link}';

$L['tiuorders_done_mail_toseller_header'] = 'Выплата по заказу № {$order_id} ({$product_title})';
$L['tiuorders_done_mail_toseller_body'] = 'Поздравляем! На ваш счет поступила оплата по заказу № {$order_id} ([{$product_id}] {$product_title}) в размере {$summ} с учетом комиссии сервиса {$tax}%. Подробности заказа смотрите по ссылке: {$link}';

$L['tiuorders_sales_paidorders'] = 'Оплаченные заказы';
$L['tiuorders_sales_doneorders'] = 'Исполненные заказы';
$L['tiuorders_sales_claimorders'] = 'Проблемные заказы';
$L['tiuorders_sales_cancelorders'] = 'Отмененные заказы';

$L['tiuorders_purchases_paidorders'] = 'Оплаченные покупки';
$L['tiuorders_purchases_doneorders'] = 'Исполненные покупки';
$L['tiuorders_purchases_claimorders'] = 'Проблемные покупки';
$L['tiuorders_purchases_cancelorders'] = 'Отмененные покупки';

$L['tiuorders_status_paid'] = 'Оплаченный';
$L['tiuorders_status_done'] = 'Исполненный';
$L['tiuorders_status_claim'] = 'Проблемный';
$L['tiuorders_status_cancel'] = 'Отмененный';

$L['tiuorders_addclaim_title'] = 'Подача жалобы по заказу';
$L['tiuorders_addclaim_button'] = 'Подать жалобу в арбитраж';
$L['tiuorders_claim_title'] = 'Жалоба';
$L['tiuorders_claim_accept'] = 'Отменить заказ';
$L['tiuorders_claim_cancel'] = 'Отказать в жалобе';

$L['tiuorders_claim_payments_seller_desc'] = 'Выплата за заказ №{$order_id} ([ID {$product_id}] {$product_title}), согласно решению администрации сайта.';
$L['tiuorders_claim_payments_customer_desc'] = 'Возврат за заказ №{$order_id} ([ID {$product_id}] {$product_title}), согласно решению администрации сайта.';

$L['tiuorders_claim_error_cost'] = 'Сумма выплат не соответствует общей стоимости заказа';

$L['tiuorders_addclaim_mail_toseller_header'] = 'Жалоба по заказу № {$order_id}';
$L['tiuorders_addclaim_mail_toseller_body'] = 'Покупатель подал жалобу по заказу № {$order_id} ([ID {$product_id}] {$product_title}). Подробность смотрите по ссылке: {$link}';

$L['tiuorders_addclaim_mail_toadmin_header'] = 'Жалоба по заказу № {$order_id}';
$L['tiuorders_addclaim_mail_toadmin_body'] = 'Покупатель подал жалобу по заказу № {$order_id} ([ID {$product_id}] {$product_title}). Подробность смотрите по ссылке: {$link}';

$L['tiuorders_acceptclaim_mail_toseller_header'] = 'Отмена заказа № {$order_id}';
$L['tiuorders_acceptclaim_mail_toseller_body'] = 'Заказ № {$order_id} ([ID {$product_id}] {$product_title}) отменен в связи с тем, что покупатель подал жалобу. Подробности смотрите по ссылке: {$link}';

$L['tiuorders_acceptclaim_mail_tocustomer_header'] = 'Отмена заказа № {$order_id}';
$L['tiuorders_acceptclaim_mail_tocustomer_body'] = 'Заказ № {$order_id} ([ID {$product_id}] {$product_title}) отменен в связи с вашей жалобой. Подробности смотрите по ссылке: {$link}';

$L['tiuorders_cancelclaim_mail_tocustomer_header'] = 'Жалобы по заказу № {$order_id} отклонена';
$L['tiuorders_cancelclaim_mail_tocustomer_body'] = 'Ваша жалоба по заказу № {$order_id} ([ID {$product_id}] {$product_title}) отклонена администрацией сайта. Подробности смотрите по ссылке: {$link}';

$L['tiuorders_file'] = 'Файлы для продажи';
$L['tiuorders_file_for_download'] = 'Файлы для скачивания';
$L['tiuorders_file_download'] = 'Скачать';