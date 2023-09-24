<!-- BEGIN: MAIN -->
<div class="content">
	<div class="breadcrumb">{BREADCRUMBS}</div>

	
	<div class="row">
		<div class="span3">
			<h4>{PHP.L.costcalc_title}</h4>
			<span>{PHP.L.costcalc_desc}</span>	
		</div>	
		<div class="span9">
			<div class="row">
				<div class="span9">
						<!-- BEGIN: CC_ROW -->
							<div>
								<h4>
									<a href="{CC_ROW_ID|cot_url('costcalculator','m=fill&id=$this')}">{CC_ROW_NAME}</a>
									<div class="label label-success">({CC_ROW_NUMROW})</div>
								</h4>						
									<!-- IF {CC_ROW_ID|cot_cc_isfill($this)} -->
										<div class="label label-success">Заполненно</div>
									<!-- ELSE -->
										<div class="label label-warning">Не заполненно</div>
									<!-- ENDIF -->		
								<div class="label label-info">{CC_ROW_USERS}</div>
							</div>		
							<hr>	
						<!-- END: CC_ROW -->
				</div>	
			</div>		
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