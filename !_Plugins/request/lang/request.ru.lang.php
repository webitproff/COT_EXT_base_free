<?php

defined('COT_CODE') or die('Wrong URL.');

$L['request_email_subject'] = 'Новая заявка';
$L['request_email_body'] = 'Здравствуйте!'."\n\n".'
С сайта Pilothub.ru поступила новая заявка:'."\n\n".'
Объект съемки: {$rtitle}'."\n".'
Когда: {$rdeadline}'."\n".'
Имя: {$rname}'."\n".'
Телефон: {$rphone}'."\n".'
Email: {$remail}.';


$L['request_mail_buy_subject'] = 'Вы выбрали исполнителя внесли предоплату';
$L['request_mail_buy_body'] = 'Добрый день, {$zak_name}!<br/>
Вы выбрали исполнителя для заказа:
<br/>
<br/>
{$request_title}
<br/>
<br/>
Исполнитель: <a href="{$pilot_url}">{$pilot_name}</a><br/>
Стоимость:  {$cost_full} рублей<br/>
Предоплата в сумме {$cost_tax} рублей внесена.<br/>
Оставшуюся сумму вам необходимо оплатить после выполнения заказа.
<br/><br/>
В ближайшее время мы свяжемся с вами и договоримся о встрече с пилотом.<br/><br/>
<a href="{$reg_url}">Зарегистрируйтесь</a> на Pilothub и выбирайте пилотов самостоятельно!<br/><br/>';