<!-- BEGIN: MAIN -->
<div class="content">
	<div class="breadcrumb">{PHP.L.costcalc_title}</div>
	<div class="row">
		<div class="span3">
			<h4>{PHP.L.costcalc_title}</h4>
			<span>{PHP.L.costcalc_desc}</span>	
			<!-- IF {CC_ALLOW_FILL}  -->
				<a href="{PHP|cot_url('costcalculator', 'm=fill')}" class="btn btn-info">{PHP.L.cc_fill_calculate}</a>
			<!-- ENDIF -->		
		</div>	
		<div class="span9">
		<!-- BEGIN: CC_ROW -->		
			<div class="row">
				<div class="span9">
					<h3><a href="{CC_ROW_ID|cot_url('costcalculator','id=$this')}">{CC_ROW_NAME} ({CC_ROW_NUMROW})</a></h3>
					<p>{CC_ROW_DESC}</p>
					<div class="pull-left label label-info">{CC_ROW_USERS}</div>
					<div class="pull-right"><a href="{CC_ROW_ID|cot_url('costcalculator','id=$this')}" class="btn btn-info">{PHP.L.Open}</a></div>
				</div>
			</div>
			<hr>	
		<!-- END: CC_ROW -->
			<div class="row">
				<div class="span12">
					<!-- IF {PAGENAV_COUNT} > 0 -->	
						<div class="pagination"><ul>{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul></div>
					<!-- ELSE -->
						<div class="alert">{PHP.L.Noitemsfound}</div>
					<!-- ENDIF -->
				</div>
			</div>
		</div>
	</div>		
</div>
<!-- END: MAIN -->