<!-- BEGIN: MAIN -->
<form action="{BOOK_ID|cot_url('plug', 'r=mailchimp&a=add&id='$this), '', true}" method="post" id="spf_{FORM_ID}">
  <input type="hidden" name="rsp_check" value="{FORM_CHECK}">
  <div class="alert alert-danger" id="spf_error_{FORM_ID}" style="display:none;"></div>
  <div class="alert alert-success" id="spf_success_{FORM_ID}" style="display:none;"></div>
  <table class="table">
    <tr>
      <td>{PHP.L.mailchimp_form_name}</td>
      <td><input type="text" name="rsp_name" /></td>
    </tr>
    <tr>
      <td>{PHP.L.mailchimp_form_email}</td>
      <td><input type="text" name="rsp_email" /></td>
    </tr>
    <tr>
      <td>{PHP.L.mailchimp_form_phone}</td>
      <td><input type="text" name="rsp_phone" /></td>
    </tr>
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
    var thisform = $(this),
      senddata = $(this).serialize();
      $('#spf_success_{FORM_ID}').hide();
      $('#spf_error_{FORM_ID}').hide();
    $.ajax({
      url: "{BOOK_ID|cot_url('plug', 'r=mailchimp&a=add&id='$this)}",
      type: "post",
      data: senddata,
      success: function(data) {
        data = JSON.parse(data);
        if (data.status == 'success') {
          thisform.find('input').val('');
          <!-- IF {FORM_REDIR} != '' -->
          location.href = '{FORM_REDIR}';
          <!-- ENDIF -->
          <!-- IF {FORM_POPUP} -->
          $.sweetModal({
            content: '<!-- IF {FORM_CHECK} == 1 -->{PHP.L.mailchimp_form_send_withcomform_popup}<!-- ELSE -->{PHP.L.mailchimp_form_send_default_popup}<!-- ENDIF -->',
            icon: $.sweetModal.ICON_SUCCESS
          });
          <!-- ENDIF -->
          <!-- IF {FORM_REDIR} == '' AND !{FORM_POPUP} -->
          $('#spf_success_{FORM_ID}').show().html(data.msg);
          <!-- ENDIF -->
        } else {
          <!-- IF {FORM_POPUP} -->
          $.sweetModal({
            content: data.msg,
            icon: $.sweetModal.ICON_WARNING
          });
          <!-- ELSE -->
          $('#spf_error_{FORM_ID}').show().html(data.msg);
          <!-- ENDIF -->
        }
      }
    });
  });
</script>

<!-- END: MAIN -->
