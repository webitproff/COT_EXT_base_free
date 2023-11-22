<?php
/**
 * Localization file for SMS.ru
 * @author Andrey Matsovkin
 * @copyright Copyright (c) 2011-2014
 * @license Distributed under BSD license.
 * Made with «Extension Template» (https://github.com/macik/cot-extension_template)
*/

defined('COT_CODE') or die('Wrong URL');

$L['cfg_api_id'] =array('API ID','Example: 11111111-1111-1111-1111-111111111111');
$L['cfg_partner_id'] =array('Partner ID','');
$L['cfg_login'] =array('SMS.ru login','Phone number — 79110000000');
$L['cfg_password'] =array('SMS.ru password','');
$L['cfg_authtype'] =array('Type of auth method','');
$L['cfg_authtype_params'] = array('With API key','Simple login/pass','Secure login/pass');

$L['cfg_testmode'] = array('Enable test mode');
//$L['cfg_testnumber'] = array('Phone number to ');
$L['cfg_sendername'] = array('Sender name to print in SMS','You can register it <a href="http://sms.ru/?panel=mass&subpanel=senders">here</a>. And it appears in list only after you enter and your API credentials (API key or login/pass) ');
$L['cfg_testauth'] = array('Credentials test','(Enter API key or login/pass and press «Update» button twice!)');

$L['sms_no_credentials'] = 'Before check enter login/pass data and save (update) config data.';
$L['sms_loginpass_ok'] = 'Login/password is <span style="color:green;">valid</span>';
$L['sms_loginpass_error'] = 'Login/password is <span style="color:red;">invalid</span>';
$L['sms_apikey_valid'] = 'API key is <span style="color:green;">valid</span>';
$L['sms_apikey_invalid'] = 'API key is <span style="color:red;">invalid</span>';

$L['cfg_testnumber'] = array('Default test number','Used only in Admin test page. Leave blank to use you own number. ');


$L['sms_state_msg'] = array(
	100	=> 'Запрос выполнен',
	101	=> 'Сообщение передается оператору',
	102	=> 'Сообщение отправлено (в пути)',
	103	=> 'Сообщение доставлено',
	104	=> 'Не может быть доставлено: время жизни истекло',
	105	=> 'Не может быть доставлено: удалено оператором',
	106	=> 'Не может быть доставлено: сбой в телефоне',
	107	=> 'Не может быть доставлено: неизвестная причина',
	108	=> 'Не может быть доставлено: отклонено',
	200	=> 'Неправильный api_id',
	201	=> 'Не хватает средств на лицевом счету',
	202	=> 'Неправильно указан получатель (Номер телефона в неправильном формате)',
	203	=> 'Нет текста сообщения',
	204	=> 'Имя отправителя не согласовано с администрацией',
	205	=> 'Сообщение слишком длинное (превышает 8 СМС)',
	206	=> 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
	207	=> 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
	208	=> 'Параметр time указан неправильно',
	209	=> 'Вы добавили этот номер (или один из номеров) в стоп-лист',
	210	=> 'Используется GET, где необходимо использовать POST',
	211	=> 'Метод не найден',
	212	=> 'Текст сообщения необходимо передать в кодировке UTF-8 (вы передали в другой кодировке)',
	220	=> 'Сервис временно недоступен, попробуйте чуть позже.',
	230	=> 'Сообщение не принято к отправке, так как на один номер в день нельзя отправлять более 250 сообщений.',
	300	=> 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
	301	=> 'Неправильный пароль, либо пользователь не найден',
	302	=> 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)',
	'sms/send' => 'Сообщение принято к отправке.',
	'sms/status' => 'Сообщение находится в нашей очереди',
	'auth/check' => 'ОК, номер телефона и пароль совпадают.',
	'stoplist/add' => 'Номер добавлен в стоплист.',
	'stoplist/del' => 'Номер удален из стоплиста.',
	'stoplist/get' => 'Запрос обработан.',
	'req_error' => 'Ошибка запроса',
);

$adminhelp1 = '';