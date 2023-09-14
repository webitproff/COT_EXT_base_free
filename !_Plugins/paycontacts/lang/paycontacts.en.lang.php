<?php
defined('COT_CODE') or die('Wrong URL.');

$L['cfg_cost'] = array ('Cost in a month', '');
$L['cfg_extra'] = array ('Specify экстраполя which will be available after a subscription in the tag {_CONTACTS_SHOW}', '');

$L['info_desc'] = 'Subscription to viewing of contacts';

$L['paypaycontacts_buy_title'] = 'Purchase of a subscription to viewing of contacts';
$L['paypaycontacts_buy_paydesc'] = 'Purchase of a subscription to viewing of contacts';
$L['paypaycontacts_costofmonth'] = 'Cost in a month';
$L['paypaycontacts_error_months'] = 'Specify period of validity of service';

$L['paypaycontacts_buy'] = 'to Purchase';
$L['paypaycontacts_month'] = 'month';

$L['paypaycontacts_header_buy'] = 'To purchase a subscription to viewing of contacts';
$L['paypaycontacts_header_expire'] = 'A subscription works to';
$L['paypaycontacts_header_expire_short'] = 'A subscription to';
$L['paypaycontacts_header_extend'] = 'To extend a subscription';

$L['paypaycontacts_error_monthsempty'] = 'Validity period of service isnt specified';

$L['paypaycontacts_buy_tag'] = '<href="'. COT_ABSOLUTE_URL . cot_url('plug', 'e=paycontacts').'">For viewing of contacts is necessary a subscription</a>';
$L['paypaycontacts_buy_user_tag'] = 'Unfortunately, the user does not activate the subscription, you can not see the contacts';

$L['paypaycontacts_mail_title_admin'] = 'New purchase of a subscription to contacts';
$L['paypaycontacts_mail_buy_title_user'] = 'The subscription is activated by';

$L['paypaycontacts_mail_buy_user'] = 'Hello, {$user_name}. '. "\n\n" . 'subscription on viewing of contacts is successfully activated.';
$L['paypaycontacts_mail_buy_admin'] = 'User {$user_name}. uspshno paid a subscription to viewing of contacts';

$L['paypaycontacts_mail_remind_title'] = 'Subscription to contacts';
$L['paypaycontacts_mail_remind'] = 'Remained to {$days} days before the termination of a subscription. '. "\n\n".' We recommend you <a href="'. COT_ABSOLUTE_URL. cot_url('plug', 'e=paycontacts').'"> to Extend a subscription </a>';