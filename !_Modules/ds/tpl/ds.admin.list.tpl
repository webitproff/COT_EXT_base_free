<!-- BEGIN: MAIN -->
{ADMIN_IMPORT}
			<div class="block">
					<table class="table" style="margin: 0px auto;">
						<thead>
							<tr>
              	<th style="width: 20%; text-align: center;">Диалог</th>
								<th style="width: 70%; text-align: center;">Последнее сообщение</th>
                <th style="width: 10%; text-align: center;">Удалить</th>
							</tr>
						</thead>
						<tbody>
<!-- BEGIN: DS_ROW -->
						<tr class="dialoghover">
							<td>
                <span class="ds_avatar">{DS_TO_USER_AVATAR}</span>
                <span>{DS_TO_USER_NAME}</span>
              </td>
              <td href="{DS_DIAOG_URL}" onclick="window.open('{DS_DIAOG_URL}','','Toolbar=0,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=1,Resizable=0,Width=750,Height=500');return false;">
              <div class="ds_avatar marginright10" style="float: left;">{DS_FROM_USER_AVATAR}</div>
								<div class="paddingright10 dialogmsg<!-- IF {DS_STATUS} --> unreadmsg<!-- ENDIF -->">{DS_FROM_USER_NAME}
                  <small class="pull-right">{DS_DATE}</small>
                  <br />
								  <small>{DS_TEXT}</small></div>
							</td>
              <td style="text-align: center;">
                <a href="{DS_DELETE}" onclick="window.open('{DS_DELETE}','','Toolbar=0,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=550,Height=400');return false;" class="ds_avatar" target="_blank"><img class="icon" src="images/icons/{PHP.cfg.defaulticons}/pm-delete.png" alt="Удалить" /></a>
              </td>
						</tr>
<!-- END: DS_ROW -->
						</tbody>
					</table>
			</div>

<!-- END: MAIN -->