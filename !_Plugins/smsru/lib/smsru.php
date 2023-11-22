<?php

/**
 * Class for sms.ru
 *
 * @package SMSRU
 * @author Andrey Matsovkin <macik.spb@gmail.com>
 * @link
 *
 * @license MIT
 * @version 1.1.0
 */

/*
 * TODO:
 * См.список
 * См. https://github.com/zelenin/sms_ru
 * Первести сообщения на русск. и англ.
 * Перевести админ шаблон
 * Перевести Аякс часть
 * Методы и свойства сделать приватными api login pass
 * Дописать конструктор для передачи парасетров через запятую api, logimn, pass
 * Написать метод обертку для вызова основных запросов к апи
 * Подготовить PHPDoc Выложить на ГитХаб
 */

class SMSRU
{

	const VERSION = '1.1.0';

	const API_URL = 'http://sms.ru';

	public $api_id = '';

	public $partner_id = '';

	public $auth_type = 0;
	// 0 - by API key
	// 1 - by login/pass simple
	// 2 - by login/pass secure
	public $login = '';

	public $pass = '';

	public $sender_name = '';

	public $test_mode = false; // enable API test mode
	public $balance = ''; // balance
	public $text = ''; // text of massage
	public $to = ''; // phone numbers (comma separated string OR array)
	public $translit = null; // transliterate SMS text
	public $debug = false;

	public $request_info = array();

	public $lang_str = array(
		100 => 'Запрос выполнен',
		101 => 'Сообщение передается оператору',
		102 => 'Сообщение отправлено (в пути)',
		103 => 'Сообщение доставлено',
		104 => 'Не может быть доставлено: время жизни истекло',
		105 => 'Не может быть доставлено: удалено оператором',
		106 => 'Не может быть доставлено: сбой в телефоне',
		107 => 'Не может быть доставлено: неизвестная причина',
		108 => 'Не может быть доставлено: отклонено',
		200 => 'Неправильный api_id',
		201 => 'Не хватает средств на лицевом счету',
		202 => 'Неправильно указан получатель (Номер телефона в неправильном формате)',
		203 => 'Нет текста сообщения',
		204 => 'Имя отправителя не согласовано с администрацией',
		205 => 'Сообщение слишком длинное (превышает 8 СМС)',
		206 => 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
		207 => 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
		208 => 'Параметр time указан неправильно',
		209 => 'Вы добавили этот номер (или один из номеров) в стоп-лист',
		210 => 'Используется GET, где необходимо использовать POST',
		211 => 'Метод не найден',
		212 => 'Текст сообщения необходимо передать в кодировке UTF-8 (вы передали в другой кодировке)',
		220 => 'Сервис временно недоступен, попробуйте чуть позже.',
		230 => 'Сообщение не принято к отправке, так как на один номер в день нельзя отправлять более 250 сообщений.',
		300 => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
		301 => 'Неправильный пароль, либо пользователь не найден',
		302 => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)',

		'sms/send' => 'Сообщение принято к отправке.',
		'sms/status' => 'Сообщение находится в нашей очереди',
		'auth/check' => 'ОК, номер телефона и пароль совпадают.',
		'stoplist/add' => 'Номер добавлен в стоплист.',
		'stoplist/del' => 'Номер удален из стоплиста.',
		'stoplist/get' => 'Запрос обработан.',

		'req_error' => 'Ошибка запроса',
		'api_error' => 'Ошибка запроса к API'
	);

	public $status_code = 0; // last status code
	public $status_message = ''; // last status message
	private $token = '';

	private $methods = array(
		'sms/send',
		'sms/mail',
		'sms/status',
		'sms/cost',
		'my/balance',
		'my/limit',
		'my/senders',
		'auth/get_token',
		'auth/check',
		'stoplist/add',
		'stoplist/del',
		'stoplist/get'
	// 'sms/ucs', // incoming format
		);

	private $nocode_methods = array(
		'auth/get_token',
		'sms/ucs'
	);

	public function __construct($params)
	{
		$reflect = new \ReflectionClass('SMSRU');
		$props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

		foreach ($props as $prop)
		{
			$propname = $prop->getName();
			if ($params[$propname])
			{
				if ($propname == 'lang_str')
				{
					$this->$propname = $params[$propname] + $this->$propname;
				}
				else
				{
					$this->$propname = $params[$propname];
				}
			}
		}
	}

	function api_request($method, $reqtype = 'GET', $params = null)
	{
		$this->status_code = null;
		$this->status_message = '';
		if ($reqtype == 'GET' && is_array($params))
		{
			$query = http_build_query($params);
		}
		$req_url = self::API_URL . '/' . $method . ($query ? '?' . $query : '');
		$ch = curl_init($req_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		if ($this->debug) curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

		if ($reqtype == 'POST' && is_array($params))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		elseif (is_array($params))
		{}
		$response = curl_exec($ch);
		if (curl_errno($ch))
		{
			$this->status_message = $this->lang_str['req_error'] . ': ' . curl_error($ch);
		}
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($this->debug)
		{
			$info = curl_getinfo($ch);
			$this->request_info = $info;
		}
		if ($code != 200)
		{
			$this->status_code = $code;
			$this->status_message = $this->lang_str['api_error'];
		}
		curl_close($ch);
		return $response;
	}

	function check_state($response, $method = '')
	{
		if (! $response)
		{
			$this->status_message = $this->lang_str['req_error'];
			return false;
		}
		if (in_array($method, $this->nocode_methods))
		{
			return $response ? $response : false;
		}
		list ($status_code, $response_data) = explode("\n", $response, 2);
		$message = $this->lang_str[$status_code];
		if ($status_code == 100)
		{
			if (array_key_exists($method, $this->lang_str))
			{
				$message = $this->lang_str[$method];
			}
		}
		$this->status_code = $status_code;
		$this->status_message = $message;
		if ($status_code >= 100 && $status_code < 200)
		{
			if ($response_data /*&& strpos($response_data , "\n")*/) $response_data = explode("\n", $response_data);
			return $response_data ? $response_data : true;
		}
		else
		{
			return false;
		}
	}

	function auth_get_token()
	{
		$this->token = $this->api_request('auth/get_token');
		return $this->token;
	}

	/**
	 * auth params init
	 *
	 * @param string $auth_type
	 * @return array
	 */
	private function init_auth($auth_type = null)
	{
		$req_param = array();
		if (! $auth_type) $auth_type = $this->auth_type;
		switch ($auth_type)
		{
			case '1': // simple login/pass
				if ($this->login && $this->pass)
				{
					$req_param['login'] = $this->login;
					$req_param['password'] = $this->pass;
				}
				else
				{
					$use_apikey = true;
				}
				break;
			case '2': // secure login/pass
				if ($this->login && $this->pass)
				{
					if (! $this->token)
					{
						$this->auth_get_token();
					}
					$req_param['sha512'] = hash('sha512', $this->pass . $this->token);
					$req_param['login'] = $this->login;
					$req_param['token'] = $this->token;
				}
				else
				{
					$use_apikey = true;
				}

				break;

			default: // by API key
				$use_apikey = true;
		}
		if ($use_apikey)
		{
			$req_param['api_id'] = $this->api_id;
		}
		if ($this->test_mode) $req_param['test'] = 1;
		return $req_param;
	}

	function send($param)
	{
		if (! $param)
		{
			$param['text'] = $this->text;
			$to = $this->to;
			if (is_string($to))
			{
				$to = explode(',', $to);
			}
			if (is_array($to))
			{
				$to = implode(',', $to);
				$to = array_slice($to, 0, 100);
			}
			$param['to'] = $to;
		}
		
		$req_param = $this->init_auth();
		if (! $this->test_mode) $req_param['partner_id'] = $this->partner_id;
		if ($this->translit) $req_param['translit'] = 1;
		$req_param = $req_param + $param;
		$response = $this->api_request('sms/send', 'POST', $req_param);
		$check = $this->check_state($response);
		if (is_array($check))
		{
			$this->sended_id = $check;
			$last = array_pop($check);
			$result = array();
			if (substr($last, 0, 7) == 'balance')
			{
				$this->balance = substr($last, 8);
				array_pop($this->sended_id);
				$result['balance'] = $this->balance;
			}
			$result['id'] = $this->sended_id;
			return $result;
		}
		else
		{
			return false;
		}
	}

	function sms_status($id)
	{
		$req_param = $this->init_auth();
		$req_param['id'] = $id;
		$response = $this->api_request('sms/status', 'POST', $req_param);
		$check = $this->check_state($response);
		if ($check)
		{
			return array(
				'result' => true,
				'message' => $this->status_message
			);
		}
		return false;
	}

	function sms_cost($param)
	{
		if (! $param)
		{
			$param['text'] = $this->text;
			$to = $this->to;
			if (is_array($to)) $to = $to[0];
			if (strpos($to, ','))
			{
				list ($to) = explode(',', $to, 1);
			}
			$param['to'] = $to;
		}
		$req_param = $this->init_auth();
		$req_param = $req_param + $param;
		$response = $this->api_request('sms/cost', 'POST', $req_param);
		$check = $this->check_state($response);

		if (is_array($check))
		{
			return array(
				'cost' => $check[0],
				'length' => $check[1]
			);
		}
		return false;
	}

	function my_balance()
	{
		$req_param = $this->init_auth();
		$response = $this->api_request('my/balance', 'POST', $req_param);
		$check = $this->check_state($response);
		if ($check)
		{
			$this->balance = $check[0];
			return $this->balance;
		}
		return false;
	}

	function my_limit()
	{
		$req_param = $this->init_auth();
		$req_param['id'] = $id;
		$response = $this->api_request('my/limit', 'POST', $req_param);
		$check = $this->check_state($response);
		if ($check)
		{
			return array(
				'limit' => $check[0],
				'sended' => $check[1]
			);
		}
		return false;
	}

	function my_senders()
	{
		$req_param = $this->init_auth();
		$req_param['id'] = $id;
		$response = $this->api_request('my/senders', 'POST', $req_param);
		$check = $this->check_state($response);
		if (is_array($check))
		{
			foreach ($check as $key => $value)
			{
				if (! $value) unset($check[$key]);
			}
			return $check;
		}
		return false;
	}

	function auth_check($type = 2)
	{
		$req_param = $this->init_auth($type);
		$response = $this->api_request('auth/check', 'POST', $req_param);
		$check = $this->check_state($response);
		return $check;
	}
}