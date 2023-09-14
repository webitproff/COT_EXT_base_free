<!-- BEGIN: MAIN -->
<div class="breadcrumb">{DS_PAGETITLE}</div>
			<div class="block">
					<table class="table" style="margin: 0px auto; max-width: 60%;">
						<thead>
							<tr>
              	<th class="width30 text-center">Диалог</th>
								<th class="width70 text-center">Сообщения</th>
							</tr>
						</thead>
						<tbody>
<!-- BEGIN: DS_ROW -->
						<tr class="dialoghover">
							<td>
                <span class="ds_avatar">{DS_OPPONENT_AVATAR}</span>
								<span>{DS_OPPONENT_NAME}</span>
              </td>
              <td class="dialog_body" href="{DS_DIAOG_URL}">
                <div class="ds_avatar marginright10" style="float: left;">{DS_FROM_USER_AVATAR}</div>
								<div class="paddingright10 dialogmsg<!-- IF {DS_STATUS} --> unreadmsg<!-- ENDIF -->">{DS_FROM_USER_NAME}
                  <small class="pull-right">{DS_TIME_AGO}</small>
                  <br />
								  <small>{DS_TEXT}</small></div>
							</td>
						</tr>
<!-- END: DS_ROW -->
						</tbody>
					</table>
			</div>

<!-- END: MAIN -->