<!-- BEGIN: MAIN -->

<div class="pull-right">
	<a href="{PHP|cot_url('admin', 'm=other&p=seo&n=add')}" class="btn btn-success">Создать</a>
</div>
<h2>SEO-данные</h2>
<!-- IF {TOTALSEO} > 0 -->
<div class="block">	
	<table class="table table-bordered cells">
		<!-- BEGIN: SEO_ROW -->
		<tr>
			<td>{SEO_ROW_AREA}</td>
			<td><!-- IF {SEO_ROW_CAT} -->{SEO_ROW_CAT}<!-- ELSE --><!-- ENDIF --></td>
			<td><!-- IF {SEO_ROW_CITY} -->{SEO_ROW_CITY}<!-- ELSE --><!-- ENDIF --></td>
			<td>{SEO_ROW_TITLE}</td>
			<td align="right">
				<a href="{SEO_ROW_ID|cot_url('admin', 'm=other&p=seo&n=edit&id='$this)}" class="btn">{PHP.L.Edit}</a>
				<a href="{SEO_ROW_ID|cot_url('admin', 'm=other&p=seo&a=delete&id='$this)}" class="btn btn-danger">{PHP.L.Delete}</a>
			</td>
		</tr>
		<!-- END: SEO_ROW -->
	</table>
</div>
<!-- ELSE -->
<div class="alert">SEO-данные еще не созданы</div>
<!-- ENDIF -->

<!-- BEGIN: ADDSEO -->
<div class="block">	
	<h3>Создание SEO-данных:</h3>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{SEO_FORM_ACTION_URL}" method="POST" class="form-horizontal">
		<table class="table table-bordered">
		<tr>
			<td>Раздел</td>
			<td>{SEO_FORM_AREA}</td>
		</tr>
		<tr>
			<td>Категория</td>
			<td>{SEO_FORM_CAT}</td>
		</tr>
		<tr>
			<td>Город</td>
			<td>{SEO_FORM_CITY}</td>
		</tr>
		<tr>
			<td>Title</td>
			<td>{SEO_FORM_TITLE}</td>
		</tr>
		<tr>
			<td>Desc</td>
			<td>{SEO_FORM_DESC}</td>
		</tr>
		<tr>
			<td>h1</td>
			<td>{SEO_FORM_H1}</td>
		</tr>
		<tr>
			<td>Текст</td>
			<td>{SEO_FORM_TEXT}</td>
		</tr>
	</table>
		<button class="btn btn-success">{PHP.L.Add}</button>
	</form>
</div>
<!-- END: ADDSEO -->

<!-- BEGIN: EDITSEO -->
<div class="block">	
	<h3>Редактирование SEO-данных:</h3>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{SEO_FORM_ACTION_URL}" method="POST" class="form-horizontal">
		<table class="table table-bordered">
		<tr>
			<td>Раздел</td>
			<td>{SEO_FORM_AREA}</td>
		</tr>
		<tr>
			<td>Категория</td>
			<td>{SEO_FORM_CAT}</td>
		</tr>
		<tr>
			<td>Город</td>
			<td>{SEO_FORM_CITY}</td>
		</tr>
		<tr>
			<td>Title</td>
			<td>{SEO_FORM_TITLE}</td>
		</tr>
		<tr>
			<td>Desc</td>
			<td>{SEO_FORM_DESC}</td>
		</tr>
		<tr>
			<td>h1</td>
			<td>{SEO_FORM_H1}</td>
		</tr>
		<tr>
			<td>Текст</td>
			<td>{SEO_FORM_TEXT}</td>
		</tr>
	</table>
		<button class="btn btn-success">{PHP.L.Update}</button>
	</form>
</div>
<!-- END: EDITSEO -->

<!-- END: MAIN -->