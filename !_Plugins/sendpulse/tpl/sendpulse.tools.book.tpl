<!-- BEGIN: MAIN -->
<div class="container">
	<div class="row">
		<div class="span12">
      <h3>Адресная книга №{BOOK_ID} "{BOOK_NAME}" <small><a href="{PHP|cot_url('admin', 'm=other&p=sendpulse')}">Назад к списку</a></small></h3>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		</div>
	</div>
  <hr>
	<div class="row">
		<div class="span2"><b>Емаил</b></div>
		<div class="span2"><b>Телефон</b></div>
		<div class="span2"><b>Пользователь</b></div>
    <div class="span5"><b>Переменные</b></div>
    <div class="span1"><b>Действие</b></div>
	</div>
  <hr>
	<!-- BEGIN: LIST_ROW -->
	<div class="row listrow_{LIST_ROW_JJ}">
		<div class="span2">{LIST_ROW_EMAIL}</div>
		<div class="span2">{LIST_ROW_PHONE}</div>
		<div class="span2"><!-- IF {LIST_ROW_USER} --><a href="{LIST_ROW_USER|cot_url('users', 'm=details&u='$this)}" target="_blank">{LIST_ROW_USER}</a><!-- ENDIF --></div>
    <div class="span5">{LIST_ROW_VARIABLES}</div>
    <div class="span1"><!-- IF {LIST_ROW_EMAIL} --><a href="#" onclick="event.preventDefault(); $.get('index.php?r=sendpulse&a=del&id={BOOK_ID}&email={LIST_ROW_EMAIL}' , function(data) { $('.listrow_{LIST_ROW_JJ}').html('<div class=span12 align=center>Успешно удалено</div>'); });">Удалить</a><!-- ENDIF --></div>
	</div>
	<hr>
	<!-- END: LIST_ROW -->
</div>
<!-- END: MAIN -->