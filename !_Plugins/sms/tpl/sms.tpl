<!-- BEGIN: MAIN --> 

<h4>Отчет отправки SMS</h4>
<br/>
<h6><a href="javascript:history.back();"><span class="glyphicon glyphicon-arrow-left"></span></a> <a href="javascript:history.back();">назад</a></h6>
<table class="table table-bordered">
<tr>
	<th>Дата отправки</th>
	<th>Номер</th>
	<th>Пользователь</th>	
	<th>Сообщение</th>
	<th>API</th>
</tr>
<!-- BEGIN: LOG_ROW -->
<tr>
	<td>{LOG_ROW_DATE|cot_date('d.m.Y H:i:s', $this)}</td>
	<td>{LOG_ROW_PHONE}	</td>
	<td><!-- IF {LOG_ROW_OWNER_ID} > 0 --><a href="{LOG_ROW_OWNER_DETAILSLINK}">{LOG_ROW_OWNER_FULLNAME}</a><!-- ELSE -->Гость<!-- ENDIF --></td>	
	<td>{LOG_ROW_TEXT}</td>
	<td>{LOG_ROW_API}</td>
</tr>
<!-- END: LOG_ROW -->
</table>
<div><ul class="pagination">{PAGENAV_PAGES}</ul></div>

<!-- END: MAIN -->