<!-- BEGIN: MAIN -->
 <div class="breadcrumb">{DS_PAGETITLE}</div>   
			<div class="block">      
<!-- BEGIN: DS_ROW_EMPTY -->
						<tr style="display:none" id="error">
             <td></td>
             <td class="text-center">{PHP.L.None}</td>
            </tr>
<!-- END: DS_ROW_EMPTY -->
          <div id="scroll" class="ds_scroll" style="margin: 0px auto; max-width: 50%;">       
					<table class="cells" id="formsg">
<!-- BEGIN: DS_ROW -->
						<tr id="{DS_ROW_ID}">
							<td class="width5 ds_avatar">{DS_ROW_USER_AVATAR}</td>
              
							<td class="<!-- IF {DS_ROW_READSTATUS} -->odd <!-- ENDIF -->width85">
              <span class="pull-right">{DS_ROW_DATE}</span>
              {DS_ROW_USER_NAME}<br />
               {DS_ROW_TEXT}
              </td>
						</tr>
<!-- END: DS_ROW -->
					</table>       
				</div>
				<form action="{DS_FORM_SEND}" method="post" id="dialogform" data-dialog-id="{DIALOG_ID}" class="ds_form">
         {DS_FORM_TEXT}
				<input id="dialogbutton" type="submit" value="{PHP.L.Reply}"/>
				</form>      
			</div>

<!-- END: MAIN -->