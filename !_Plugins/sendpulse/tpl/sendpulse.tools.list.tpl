<!-- BEGIN: MAIN -->
<div class="container">
	<div class="row">
		<div class="span12">
      <h3>
        Адресные книги
        <br>
        <small>Баланс SendPulse {BALANCE}</small>
      </h3>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		</div>
	</div>
  <hr>
	<div class="row">
		<div class="span3"><b>имя книги</b></div>
		<div class="span2"><b>кол-во адресов</b></div>
		<div class="span2"><b>активных адресов</b></div>
    <div class="span2"><b>неактивных адресов</b></div>
    <div class="span2"><b>дата создания</b></div>
    <div class="span1"><b>Статус</b></div>
	</div>
  <hr>
	<!-- BEGIN: LIST_ROW -->
	<div class="row">
		<div class="span3"><a href="{LIST_ROW_ID|cot_url('admin', 'm=other&p=sendpulse&id='$this)}">{LIST_ROW_NAME}</a></div>
		<div class="span2">{LIST_ROW_COUNT_ALL}</div>
		<div class="span2">{LIST_ROW_COUNT_ACT}</div>
    <div class="span2">{LIST_ROW_COUNT_INACT}</div>
    <div class="span2">{LIST_ROW_COUNT_DATE}</div>
		<div class="span1">{LIST_ROW_STATUS}</div>
	</div>
	<hr>
	<!-- END: LIST_ROW -->
</div>
<!-- END: MAIN -->