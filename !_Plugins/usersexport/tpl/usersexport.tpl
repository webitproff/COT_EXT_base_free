<!-- BEGIN: MAIN -->

<h2>Экспорт пользователей</h2>

<div class="block">
     <form method="get" action="index.php?r=usersexport&a=export" class="ajax get-exportresult">
       <input type="hidden" name="r" value="usersexport">
       <input type="hidden" name="a" value="export">
       <input type="hidden" name="usercats" value="">
       Группа: {GROUPSELECTBOX}
       <br>
       Категории (для исполнителей)
       {SELECTUSERCATS}
       <br>
       <input type="submit" value="Экспортировать">
     </form>
     <div id="exportresult"></div> 
     <style>
      .nav ul {
        margin-left: 20px;
      }
     </style>
     <script>
      var usercats = $('[name="usercatstmp"]').attr('name', '');
      usercats.change(function() {
        var new_usercats = new Array();
        usercats.each(function() {
          if($(this).prop('checked')) new_usercats.push($(this).val());
        });        
        $('[name="usercats"]').val(new_usercats.join(','));
      });
     </script>
</div>

<!-- END: MAIN -->