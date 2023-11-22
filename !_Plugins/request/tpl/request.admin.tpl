<!-- BEGIN: MAIN -->

<!-- BEGIN: LIST -->

<div class="block">	
	<table class="table table-bordered cells">
		<thead>
			<tr>
				<th>#</th>
				<th>Дата</th>
				<th>Заказчик</th>
				<th>Кого снимаем?</th>
				<th>Срок</th>
				<th>Имя</th>
				<th>Телефон</th>
				<th>Email</th>
				<th>Заказ</th>
				<th>Предложение</th>
				<th>Статус</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: REQ_ROW -->
			<tr<!-- IF {REQ_ROW_STATUS} == 'new' --> class="success"<!-- ENDIF -->>
				<td>{REQ_ROW_ID}</td>
				<td>{REQ_ROW_DATE|cot_date('d.m.Y, H:i', $this)}</td>
				<td>
					<!-- IF {REQ_ROW_USERID} > 0 -->
					{REQ_ROW_USERNAME}
					<!-- ELSE -->
					Гость
					<!-- ENDIF -->
				</td>
				<td>{REQ_ROW_TITLE}</td>
				<td>{REQ_ROW_DEADLINE}</td>
				<td>{REQ_ROW_NAME}</td>
				<td>{REQ_ROW_PHONE}</td>
				<td>{REQ_ROW_EMAIL}</td>
				<td>
				<!-- IF {REQ_ROW_PROJECTID} > 0 -->
				<a href="{REQ_ROW_PROJECTID|cot_url('projects', 'id='$this)}" target="blank">Заказ</a>
				<!-- ELSE -->
				<a href="{REQ_ROW_ID|cot_url('projects', 'm=add&requestid='$this)}" target="blank">Создать заказ</a>
				<!-- ENDIF -->
				</td>
				<td>
					<!-- IF {REQ_ROW_OFFER_URL} -->
					<a href="{REQ_ROW_OFFER_URL}">Посмотреть</a>
					<!-- ENDIF -->
				</td>
				<td>{REQ_ROW_STATUS}</td>
				<td><a href="{REQ_ROW_ID|cot_url('admin', 'm=other&p=request&n=edit&id='$this)}">Изменить</a></td>
				<td>
					<a href="#deletereq_{REQ_ROW_ID}" data-toggle="modal">Удалить</a>
					<div id="deletereq_{REQ_ROW_ID}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h3 id="myModalLabel">Удалить заявку?</h3>
					  </div>
					  <div class="modal-body">
					    <a href="{REQ_ROW_DELETE_URL}" class="btn btn-danger">Удалить</a>
					    <a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Отмена</a>
					  </div>
					</div>
				</td>
			</tr>
			<!-- END: REQ_ROW -->
		</tbody>
	</table>
</div>

<!-- END: LIST -->


<!-- BEGIN: EDIT -->
<div class="block">	
	<h3>Редактирование заявки:</h3>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	<form action="{FORM_SEND}" method="POST" class="form-horizontal">
		<table class="table table-bordered">
			<tr>
				<td>Что снимаем?</td>
				<td>{FORM_TITLE}</td>
			</tr>
			<tr>
				<td>Когда планируется съемка</td>
				<td>{FORM_DEADLINE}</td>
			</tr>
			<tr>
				<td>Как вас зовут?</td>
				<td>{FORM_NAME}</td>
			</tr>
			<tr>
				<td>Телефон</td>
				<td>{FORM_PHONE}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{FORM_EMAIL}</td>
			</tr>
		</table>
		<button class="btn btn-success">{PHP.L.Update}</button>
	</form>
</div>

<script type="text/javascript">

$().ready(function() {

    $(".datepicker").datepicker({
      dateFormat: "dd.mm.yy",
      buttonText: "Choose",
      minDate: '+1d'
    });

});

</script>

<!-- END: EDIT -->

<!-- END: MAIN -->