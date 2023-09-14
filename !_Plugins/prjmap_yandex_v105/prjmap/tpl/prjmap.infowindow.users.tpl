<!-- BEGIN: MAIN -->
<div style="margin-bottom:10px;">
 <h2><a href="{USERS_ROW_DETAILSLINK}" target="blank">{USERS_ROW_NICKNAME}</a></h2>

    	<div class="panel-img">
    			<a href="{USERS_ROW_DETAILSLINK}">
            <!-- IF {PHP.urr.user_avatar} -->
              <img src="{PHP.urr.user_avatar}" alt="{USERS_ROW_NICKNAME}">
            <!-- ELSE -->
              <img src="/datas/defaultav/blank.png" alt="{USERS_ROW_NICKNAME}">
            <!-- ENDIF -->
          </a>
    	</div>

  {USERS_ROW_TEXT}

  <div class="clearfix"></div>

  <div style="min-width:250px;">
    <div class="pull-right">{USERS_ROW_CITY}, {USERS_ROW_PRJMAP_ADR}
    </div>
  </div>
</div>
<!-- END: MAIN -->
