<!-- BEGIN: MAIN -->
<div>
{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
<form class="form-horizontal" action="{CC_FORM_ACTION}" method="POST" id="cc_form">
	<fieldset>
		<legend>Калькулятор - {PHP.L.Add}/{PHP.L.Edit}</legend>
		<div class="control-group">
			<label class="control-label" for="input01">Название</label>
			<div class="controls">
				<p class="help-block">Обозначение/Название калькулятора в списке</p>
				{CC_NAME}				
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="textarea">Описание</label>
			<div class="controls">
				<p class="help-block">Описание калькулятора</p>
				{CC_DESC}
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="optionsCheckbox">#ID Групп</label>
			<div class="controls">
				<p class="help-block">Группы что могут формировать прайс</p>
				{CC_GROUP}				
			</div>			
		</div>

		<div class="control-group">
			<label class="control-label" for="textarea">№</label>
			<div class="controls">
				<p class="help-block">Порядковый номер в списке калькуляторов</p>
				{CC_ORDER}				
			</div>
		</div>


		<div class="form-actions">			
			<a href="{PHP|cot_url('admin', 'm=other&p=costcalculator')}" title="{PHP.L.Administration}" class="btn btn-default"><i class="icon-chevron-left"></i></a>
			<button type="submit" class="btn btn-primary">
			{PHP.L.Submit}
			</button>
		</div>
	</fieldset>
</form>

</div>
<!-- END: MAIN -->