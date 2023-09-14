<!-- BEGIN: MAIN -->
<script>
var noedit = false;
var valuta = '{PHP.cfg.payments.valuta}';
 $(document).ready(function(){
	$(".editableoffer_{OFFER_ID}")
		.click(function(event) {
      noedit = true;
			var $editable = $(this);
			if($editable.hasClass('active')) {
				return;
			}
			var contents = $.trim($editable.html().replace(/\/p>/g,"/p>\n\n"));
			$editable
				.addClass('active')
				.empty();
			
			var editElement = '<textarea style="width:100%;max-width:100%"></textarea>';
      if($editable.attr('data-type') == 'cost' || $editable.attr('data-type') == 'time_min' || $editable.attr('data-type') == 'time_max') {
        editElement = '<input style="width:40px"></input>';
      }
             
			$(editElement)
				.val(contents)
				.appendTo($editable)
				.focus()
				.blur(function(event) {
					$editable.trigger('blur');
				});
		  })	
		.blur(function(event) {
      if (noedit) {
  			var $editable = $(this);
  			var edited = $editable.find('input,textarea').val();

        if($editable.attr('data-type') == 'cost' || $editable.attr('data-type') == 'time_min' || $editable.attr('data-type') == 'time_max') {
          edited = edited.replace(/\/p>/g,"/p>\n\n").replace(/\s+/g, '');
        }

          $.ajax({
              type: 'POST',
              url: 'index.php?r=editoffer',
              data: { id: {OFFER_ID}, text: edited, type: $editable.attr('data-type')},
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