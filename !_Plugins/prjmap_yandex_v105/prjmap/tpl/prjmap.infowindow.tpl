<!-- BEGIN: MAIN -->
<div style="margin-bottom:10px;">
 <h2><a href="{PRJ_ROW_URL}" target="blank">{PRJ_ROW_SHORTTITLE}</a></h2>

    <!-- IF {PRJ_ROW_MAVATAR.1} -->
    	<div class="panel-img">
    			<a href="{PRJ_ROW_URL}"><img src="{PRJ_ROW_MAVATAR.1|cot_mav_thumb($this, 150, 150, crop)}" /></a>
    	</div>
    <!-- ENDIF -->

  {PRJ_ROW_SHORTTEXT}

  <div class="clearfix"></div>

  <div style="min-width:250px;">
    <div class="pull-right">{PRJ_ROW_CITY}, {PRJ_ROW_PRJMAP_ADR}
    </div>
  </div>
</div>
<!-- END: MAIN -->
