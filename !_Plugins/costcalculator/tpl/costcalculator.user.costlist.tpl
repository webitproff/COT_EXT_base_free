<!-- BEGIN: MAIN -->			
			<ul>
				<!-- BEGIN: CC_ROW_USERCOST -->
					<li>
						<div>
							{CC_ROW_NAME} {CC_ROW_COST} {CC_ROW_UNITS} 
							<!-- IF {CC_ROW_CALCCOST}  --> 
								<span class="label label-success">{CC_ROW_CALCCOST} {CC_ROW_CURRENCY}</span>
							<!-- ENDIF -->
						</div>
					</li>
				<!-- END: CC_ROW_USERCOST -->				
			</ul>
			<!-- IF {CC_LASTUPDATE}  --> 
				<span class="alert alert-info pull-left">{PHP.L.cc_updatedon} {CC_LASTUPDATE|cot_date('Y-m-d',$this)}</span>
			<!-- ENDIF --> 	
			<!-- IF {CC_SUMM}  --> 
				<span class="alert alert-success pull-right">{PHP.L.cc_summ} {CC_SUMM} {CC_CURRENCY}</span>
			<!-- ENDIF -->
<!-- END: MAIN -->