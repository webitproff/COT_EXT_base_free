<!-- BEGIN: MAIN -->
<div id="main">
	<h2>{PHP.L.sms_adminheader}SMS.RU API</h2>

	<div class="block">
		<h5><i class="fa fa-cog"></i> Данные подключения к API</h5>
		<div class="wrapper">

		<ul>
			<li>API ключ: <!-- IF {item.api_id} -->{item.api_id}<!-- ELSE -->не указан<!-- ENDIF --></li>
			<!-- IF {item.testnumber} --><li>Ваш телефон: {item.testnumber}</li><!-- ENDIF -->
			<!-- IF {item.password} --><li>Ваш пароль: {item.password} (скрыт)</li><!-- ENDIF -->
			<li>тип авторизаци:
			<!-- IF {item.authtype} == 0 -->по ключу<!-- ENDIF -->
			<!-- IF {item.authtype} == 1 -->по логину/паролю (без шифрования)<!-- ENDIF -->
			<!-- IF {item.authtype} == 2 -->по логину/паролю (с шифрованием)<!-- ENDIF -->
			</li>
			<!-- IF {item.testmode} --><li>Тестовый режим: <b>включен</b></li><!-- ENDIF -->
		</ul>
		<!-- IF {!PHP.api_enabled} -->
		<p>Для использования функций системы вам надо зарегистрироваться на сервисе SMS.ru, получить
		API ключ, указать в настройках ключ (рекомендуется) или пару логин пароль.</p>
		<!-- ELSE -->
		<!-- ENDIF -->
		</div>
	</div>

	<!-- IF {PHP.api_enabled} -->
	<div class="block">
		<h5><i class="fa fa-puzzle-piece"></i> Баланс</h5>
		<div class="wrapper">
		<ul>
			<li>Баланс: {PHP.balance}</li>
		</ul>
		</div>
	</div>

	<div class="block">
		<h5><i class="fa fa-puzzle-piece"></i> Лимиты</h5>
		<div class="wrapper">
		<ul>
			<li>Дневной лимит: {PHP.limit.limit}</li>
			<li>Отослано СМС: {PHP.limit.sended}</li>
		</ul>
		</div>
	</div>
	<!-- ELSE -->
	<div class="block">
		<h5><i class="fa fa-puzzle-piece"></i> Информация</h5>
		<div class="wrapper">
		<p>Основные данные не отображены, т.к. нет доступа к API. Укажите актуальные данные (API ключ или логин/пароль)
		 и выберите соответствующий тип авторизации в настройках.</p>
		</div>
	</div>

	<!-- ENDIF -->

</div>

<div class="debug">
	{DEBUG_OUTPUT}
</div>

<!-- END: MAIN -->