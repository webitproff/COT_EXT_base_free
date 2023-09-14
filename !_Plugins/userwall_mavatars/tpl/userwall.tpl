<!-- BEGIN: MAIN -->
{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
<!-- BEGIN: WALL_ADD -->
<div class="uk-form-row">
<form class="uk-form" name="newwallpost" action="{PHP|cot_url('plug', 'r=userwall&a=add')}" method="post">
    <fieldset>
        <legend>Новая запись на стене</legend>
        <div class="uk-form-row">
            <textarea name="rwall_text" class="uk-width-1-1"></textarea>
        </div>
        <div class="uk-form-row">
            <button class="uk-button uk-button-success" type="submit">Отправить</button>
        </div>
    </fieldset>
</form>
<hr>
</div>
<!-- END: WALL_ADD -->

<!-- BEGIN: WALL_ROW -->
<div class="uk-panel uk-panel-box" id="wallid{WALL_ID}">
  <article class="uk-article">
     {WALL_TEXT}
      <h5>
        <div class="uk-grid">
           <div class="uk-width-8-10">
            Опубликован {WALL_DATE_AGO} <!-- IF {WALL_EDITABLE} --><a class="ajax" rel="get-wallid{WALL_ID}" href="{WALL_ID|cot_url('plug', 'r=userwall&a=edit&id='$this)}">Редактировать</a>/<a href="{WALL_ID|cot_url('plug', 'r=userwall&a=del&id='$this)}">Удалить</a><!-- ENDIF -->
           </div>
           <div class="uk-width-2-10 uk-text-right">
             <i style="cursor:pointer" data-wall-id="{WALL_ID}" class="likeuserwall uk-icon-heart<!-- IF {WALL_ISLIKED} --> uk-text-danger<!-- ENDIF -->"></i>
             <span class="likeuserwallcounter">{WALL_LIKES}</span>
           </div>
        </div>
      </h5>
  </article>
</div>  
<!-- END: WALL_ROW -->

<!-- IF {PHP.usr.id} > 0 -->
<script>
$(document).ready(function() {
 $('.likeuserwall').click(function(e) {
   e.preventDefault();
   var wall = $(this); 
   $.ajax({
      type: 'GET',
      url: 'index.php?r=userwall&a=like&id='+wall.attr('data-wall-id'),
      success: function (data) {
         wall.parent().find('.likeuserwallcounter').html(data);
         wall.toggleClass('uk-text-danger');
      }
    })
 });
});
</script>
<!-- ENDIF -->
              
<!-- END: MAIN -->