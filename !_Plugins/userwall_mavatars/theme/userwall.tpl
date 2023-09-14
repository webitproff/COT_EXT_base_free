<!-- BEGIN: MAIN -->
{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
<!-- BEGIN: WALL_ADD -->
<div class="uk-form-row">
  <form class="uk-form" name="newwallpost" action="{PHP|cot_url('plug', 'r=userwall&a=add')}" method="post" enctype="multipart/form-data">
      <fieldset>
          <legend>Новая запись на стене</legend>
          <div class="uk-form-row">
              <textarea name="rwall_text" class="uk-width-1-1"></textarea>
          </div>
          <div class="uk-form-row">
            {WALL_FORM_MAVATAR}
          </div>
          <div class="uk-form-row">
              <button class="uk-button uk-button-success" type="submit">Отправить</button>
          </div>
      </fieldset>
  </form>
</div>
<!-- END: WALL_ADD -->

<!-- BEGIN: WALL_ROW -->
<div class="uk-panel uk-panel-box" id="wallid{WALL_ID}">
  <hr>
  <article class="uk-article">
      <h5>
        Опубликована {WALL_DATE_AGO} <!-- IF {WALL_EDITABLE} --><a class="ajax" rel="get-wallid{WALL_ID}" href="{WALL_ID|cot_url('plug', 'r=userwall&a=edit&id='$this)}">Редактировать</a>/<a href="{WALL_ID|cot_url('plug', 'r=userwall&a=del&id='$this)}">Удалить</a><!-- ENDIF -->
      </h5>
      <!-- IF {PHP.cot_plugins_active.mavatars} -->
            <!-- IF {WALL_MAVATARCOUNT.IMG} > 0 -->
            <div class="wall-img">
              <!-- FOR {KEY}, {VALUE} IN {WALL_MAVATAR.IMG} -->
              <a class="wall-img-item" href="{VALUE.FILE}" data-uk-lightbox="{group:'wallid{WALL_ID}'}" style="background-image: url({VALUE.FILE});" onclick="event.preventDefault();">
                <img src="{VALUE.FILE}" alt="">
              </a>
              <!-- ENDFOR -->
            </div>
            <div class="clearfix uk-margin-bottom"></div>
            <!-- ENDIF -->
            <!-- IF {WALL_MAVATARCOUNT.FILES} > 0 -->
            <div class="<!-- IF {WALL_MAVATARCOUNT.IMG} > 0 --> uk-margin-top<!-- ENDIF -->">
             <!-- FOR {KEY}, {VALUE} IN {WALL_MAVATAR.FILES} -->
             <div class="uk-margin-bottom">
              <a href="{VALUE.FILE}" target="_blank">
                <!-- IF {VALUE.FILEEXT|file_exists('images/filetypes/'$this'.png')} -->
                  <img src="images/filetypes/{VALUE.FILEEXT}.png" width="30px" height="30px" />
                <!-- ELSE -->
                  <img src="images/filetypes/file.png" width="30px" height="30px" />
                <!-- ENDIF -->
                {VALUE.FILEORIGNAME}.{VALUE.FILEEXT}
              </a>
             </div>
             <!-- ENDFOR -->
            </div>
            <!-- ENDIF -->
      <!-- ENDIF -->

        <div class="uk-grid">
           <div class="uk-width-8-10">
             <blockquote>
               {WALL_TEXT}
             </blockquote>
           </div>
           <div class="uk-width-2-10 uk-text-right">
             <h4>
               <i style="cursor:pointer" data-wall-id="{WALL_ID}" class="likeuserwall uk-icon-heart<!-- IF {WALL_ISLIKED} --> uk-text-danger<!-- ENDIF -->"></i>
               <span class="likeuserwallcounter">{WALL_LIKES}</span>
             </h4>
           </div>
        </div>

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
