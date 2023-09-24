<!-- BEGIN: MAIN -->

<!-- IF {PHP.usr.id} == {PHP.urr.user_id} AND {FILLCC_SHOWBUTTON} --><div class="pull-right"><a href="{FILLCC_URL}" class="btn btn-success">{PHP.L.cc_fill_calculate}</a></div><!-- ENDIF -->
<hr>
<div>
	<!-- BEGIN: CC_ROWS -->
	<div class="media">
		<h4>
			<a href="{CC_URL}">{CC_NAME}</a>
		</h4>
		<div class="pull-left textright">
			<p class="owner small"> <!-- IF {CC_DESC} -->{CC_DESC}<!-- ENDIF --></p>
		</div>
		<span class="clearfix"></span>
			<!-- BEGIN: CCR_ROWS -->
				<div class="marginleft10">
					<p>{CCR_NAME}: <span clss="pull-right small">{CCR_COST} {CCR_CURRENCY} / {CCR_UNITS}</span></p>					
					<p class="small">{CCR_DESC}</p>
				</div>
			<!-- END: CCR_ROWS -->	
	</div>
	<hr/>
	<!-- END: CC_ROWS -->
</div>

<!-- IF {PAGENAV_COUNT} > 0 -->	
	<div class="pagination"><ul>{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul></div>
<!-- ELSE -->
	<div class="alert">{PHP.L.Noitemsfound}</div>
<!-- ENDIF -->

<!-- END: MAIN -->