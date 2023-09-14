<!-- BEGIN: MAIN -->

	<div class="well well-sm">
   <h4>{PHP.L.sendfieldstomail_title}</h4>

   <div id="sendfieldstomail_{FORM_ID}"></div>
		<form id="sendfieldstomail_form_{FORM_ID}">
      <input type="hidden" name="stmid" value="{FORM_ID}">
      <input type="hidden" name="sfmtype" value="{FORM_TYPE}">

      {PHP.L.sendfieldstomail_input_email}: <br>
      <input type="text" name="sfmemail" value="" class="form-control">

      <br>

      <button class="btn btn-success">{PHP.L.Submit}</button>
		</form>
	</div>

  <script>
   $(document).ready(function() {
    $('#sendfieldstomail_form_{FORM_ID}').submit(function(e) {
      e.preventDefault();
      senddata = $(this).serialize();
      $.ajax({
        url: 'index.php?r=sendfieldstomail',
        data: senddata,
        type: 'GET',
        success: function(data) {
          data = JSON.parse(data);
          if(data.status == 'success') {
            $('#sendfieldstomail_{FORM_ID}').html('');
            $('#sendfieldstomail_form_{FORM_ID}').replaceWith(data.msg);
          }
          else if(data.status == 'error') {
            $('#sendfieldstomail_{FORM_ID}').html(data.msg);
          }
        }
      });
    });
   });
  </script>

<!-- END: MAIN -->