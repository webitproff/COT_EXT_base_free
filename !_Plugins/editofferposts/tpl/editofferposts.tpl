<!-- BEGIN: MAIN -->
<script>
var editofferposts_noedit_{POST_ID} = false;
 $(document).ready(function(){
	$(".editableoffers_post_{POST_ID}")
		.click(function(event) {
      editofferposts_noedit_{POST_ID} = true;
			var $editable = $(this);
			if($editable.hasClass('active')) {
				return;
			}
			var contents = $.trim($editable.html().replace(/\/p>/g,"/p>\n\n"));
			$editable
				.addClass('active')
				.empty();
			
			var editElement = '<textarea style="width:100%;max-width:100%"></textarea>';

			$(editElement)
				.val(contents)
				.appendTo($editable)
				.focus()
				.blur(function(event) {
					$editable.trigger('blur');
				});
		  })	
		.blur(function(event) {
      if (editofferposts_noedit_{POST_ID}) {
  			var $editable = $(this);
  			var edited = $editable.find('input,textarea').val();

        $.ajax({
           type: 'POST',
           url: 'index.php?r=editofferposts',
           data: { postid: {POST_ID}, text: edited},
           success: function (data) {
  				    $editable
  					   .removeClass('active')
  					   .children()
  					   .replaceWith(edited);
             },
        })
  		 }
    });
});
</script>
<!-- END: MAIN -->