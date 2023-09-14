<!-- BEGIN: MAIN -->

<h1>Карма</h1>

<table class="table table-bordered table-striped">
	<tr>
		<td class="col-xs-2">Дата</td>
		<td class="col-xs-2">Кому</td>
		<td class="col-xs-2">От</td>
		<td class="col-xs-1">Оценка</td>
		<td>Модуль</td>
		<td>Код</td>
		<td>Управление</td>
	</tr>
	<!-- BEGIN: UKARMA_ROW -->
	<tr>
		<td class="col-xs-2">{UKARMA_ROW_DATE|cot_date('d.m.Y H:i', $this)}</td>
		<td class="col-xs-2">{UKARMA_ROW_TOUSER_NAME}</td>
		<td class="col-xs-2">{UKARMA_ROW_FROMUSER_NAME}</td>
		<td class="col-xs-1">{UKARMA_ROW_VALUE}</td>
		<td>{UKARMA_ROW_AREA}</td>
		<td>{UKARMA_ROW_CODE}</td>
		<td><a href="{UKARMA_ROW_DELETE_URL}"><i class="glyphicon glyphicon-trash"></i></a></td>
	</tr>
	<!-- END: UKARMA_ROW -->
</table>

<ul class="pagination">{ADMIN_PAGE_PAGNAV}</ul>

<!-- END: MAIN -->