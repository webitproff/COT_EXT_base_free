<!-- BEGIN: MAIN -->
 <div id="usertexthint"></div>
 <script>
 var usertexthint_cats = JSON.parse('{CATJSON}');
 $('[type="checkbox"][name="rcats[]"]').change(function() {
  var thisval = $(this).val();
  if($(this).prop('checked')) {
    if(usertexthint_cats[thisval] != null && usertexthint_cats[thisval] != '')
      $('#usertexthint').append('<p data-hintcat="'+thisval+'">' + usertexthint_cats[thisval] + '</p>');
  } else {
    $('#usertexthint').find('[data-hintcat="'+thisval+'"]').remove();
  }
 });
 $('[name="rcats[]"]:checked').change();
 </script>
<!-- END: MAIN -->