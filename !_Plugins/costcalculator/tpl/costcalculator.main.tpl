<!-- BEGIN: MAIN -->
	<div class="breadcrumb"><a href="{PHP|cot_url('costcalculator')}">{PHP.L.costcalc_title}</a> / {CC_NAME}</div>
	<div class="row">
		<div class="span3">
			<h4>{CC_NAME}</h4>
			<span>{CC_DESC}</span>			
		</div>	
		<div class="span9">
			<form action="{FORM_ACTION}" id="calculateform" method="POST">
			<!-- BEGIN: CCR_ROW -->		
				<div class="row">
					<div class="span5">
						{CCR_ROW_NAME}
						<p>
	  						<small>{CCR_ROW_DESC}</small>
						</p>
					</div>
					<div class="span2">
						{CCR_ROW_INPUT}
					</div>
					<div class="span2">
						{CCR_ROW_UNITS}
					</div>
				</div>
				<hr>	
			<!-- END: CCR_ROW -->
				<div class="row">
					<div class="span7">
							{CC_SORTLIST}
						<!-- IF {PHP.usr.isadmin} -->						
						<div class="btn-group pull-left" role="group">
						   <a class="btn btn-success" title="{PHP.L.Edit}" href="{CC_ID|cot_url('admin', 'm=other&p=costcalculator&n=configcalc&cc_id=$this')}"><i class="icon-tasks" ></i></a>
						  <a class="btn btn-info" title="{PHP.L.Edit}" href="{CC_ID|cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc&id=$this')}"><i class="icon-edit" ></i></a>
						</div>
						<!-- ENDIF -->
					</div>
					<div class="span2">
						<input type="submit" class="btn btn-success" value="{PHP.L.cc_calculate}">
					</div>
				</div>
			</form>
			<div class="row">
				<div class="span9">
					<div class="row">
						<div class="span9">
							<div class="alert alert-info">{PHP.L.cc_listof_users} ({CC_USERCOUNT})</div>
						</div>
					</div>
					<!-- BEGIN: CCU_ROW -->		
						<div class="row">
							<div class="span2 centerall">
								<a href="{CCU_ROW_USER_DETAILSLINK}">
									{CCU_ROW_USER_AVATAR}
								</a>					
								<p>{CCU_ROW_USER_COUNTRYFLAG} {CCU_ROW_USER_NAME}</p>			
							</div>
							<div class="span7">
									{CCU_ROW_COSTLIST}
							</div>
						</div>
						<hr>	
					<!-- END: CCU_ROW -->
				</div>
			</div>
		</div>
	</div>	
<!-- END: MAIN -->