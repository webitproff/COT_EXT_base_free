<!-- BEGIN: MAIN -->
<!-- BEGIN: INBOX -->
<tr>
<td class="width5 ds_avatar">{DS_ROW_USER_AVATAR}</td>
<td class="width85">
{DS_ROW_USER_NAME}<br />
{DS_ROW_TEXT}
<span class="pull-right">{DS_ROW_DATE}</span></td>
</tr>
<!-- END: INBOX -->

<!-- BEGIN: OUTBOX -->
<tr style="display:none">
<td class="width5 ds_avatar">{DS_ROW_USER_AVATAR}</td>
<td class="width85">
{DS_ROW_USER_NAME}<br />
{DS_ROW_TEXT}
<span class="pull-right">{DS_ROW_DATE}</span></td>
</tr>
<!-- END: OUTBOX -->

<!-- BEGIN: ERROR -->
<tr style="display:none" id="error">
<td></td>
<td class="text-center">{ERROR_MSG}</td></tr>
<!-- END: ERROR -->

<!-- END: MAIN -->