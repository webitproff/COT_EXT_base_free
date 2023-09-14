<!-- BEGIN: MAIN -->
<div style="margin-bottom:10px;">
 <h2><a href="{PRD_ROW_URL}" target="blank">{PRD_ROW_SHORTTITLE}</a></h2>

    <!-- IF {PRD_ROW_MAVATAR.1} -->
    	<div class="panel-img">
    			<a href="{PRD_ROW_URL}"><img src="{PRD_ROW_MAVATAR.1|cot_mav_thumb($this, 150, 150, crop)}" /></a>
    	</div>
    <!-- ENDIF -->

  {PRD_ROW_SHORTTEXT}

  <div class="clearfix"></div>

  <div style="min-width:250px;">
    <div class="pull-right">{PRD_ROW_CITY}, {PRD_ROW_PRJMAP_ADR}
    </div>
  </div>
</div>
<!-- END: MAIN -->
