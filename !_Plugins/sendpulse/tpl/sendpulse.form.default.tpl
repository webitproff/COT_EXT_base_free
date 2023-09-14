<!-- BEGIN: MAIN -->

<form action="{BOOK_ID|cot_url('plug', 'r=sendpulse&a=add&id='$this)}" method="post" id="spf_{FORM_ID}">
  <input type="hidden" name="rsp_check" value="{FORM_CHECK}">
  <div class="alert alert-danger" id="spf_alert_{FORM_ID}" style="display:none;"></div>
	<table class="table">
		<tr>
			<td>{PHP.L.sendpulse_form_email}</td>
			<td><input type="text" name="rsp_email"/></td>
		</tr>
    <!-- BEGIN: FORM_INPUTS -->
		<tr>
			<td>{INPUT_TITLE}</td>
			<td><input type="text" name="{INPUT_NAME}"/></td>
		</tr>
    <!-- END: FORM_INPUTS -->
		<tr>
			<td></td>
			<td><button class="btn btn-success">Продолжить</button></td>
		</tr>
	</table>
</form>
<script>
 $('#spf_{FORM_ID}').submit(function(e) {
  e.preventDefault();
  e.stopPropagation();
  var senddata = $(this).serialize();
  $.ajax({
    url: "{BOOK_ID|cot_url('plug', 'r=sendpulse&a=add&id='$this)}",
    type: "post",
    data: senddata,
    success: function(data) {
      data = JSON.parse(data);
      if(data.status == 'success')
      {
        $('#spf_{FORM_ID}').html(data.msg);
      } else {
        $('#spf_alert_{FORM_ID}').show().html(data.msg);
      }
    }
  });
 });
</script>

<!-- END: MAIN -->