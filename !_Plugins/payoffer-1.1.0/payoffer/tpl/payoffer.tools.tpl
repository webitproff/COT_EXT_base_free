<!-- BEGIN: MAIN -->
<div class="row">
	<div class="col-md-12">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	</div>
</div>
<div class="row"> <!-- Filter form -->
	<div class="col-md-12">
		<div class="panel panel-default margintop20">
			<div class="panel-body">
				<form class="form-inline" action="{PAYOFFER_FORM_ACTION}" method="POST" id="rl_form_user">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-5">
								<label>{PHP.L.po_adm_username}:{PAYOFFER_FORM_USERNAME|cot_rc_modify($this,"class='form-control input-sm userinputpayoffer'")}</label> 
							</div>
							<div class="col-md-5">
								<label>{PHP.L.po_adm_userofferlimit}:{PAYOFFER_FORM_USEROFFERLIMIT}</label>
							</div>
							<div class="col-md-2">
								<button class="btn btn-info" />{PHP.L.Add}</button>
							</div>
						</div>						
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>
<!-- BEGIN: ROW -->
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row paddingbottom5"> <!-- Result list -->
			<div class="col-md-2 text-center">
				#{PO_ROW_ID}
			</div>
			<div class="col-md-4" title="{RL_ROW_KEY}">
				{PO_ROW_NAME} <!-- IF {PO_ROW_FULL_NAME} AND {PO_ROW_NICKNAME} != {PO_ROW_FULL_NAME} -->({PO_ROW_FULL_NAME})<!-- ENDIF -->
			</div>
			<div class="col-md-4">
				{PHP.L.po_adm_limitoffer} {PO_ROW_PAYOFFER}
			</div>
			<div class="col-md-2">
				<div class="btn-group2">				
				<a href="{PO_ROW_CONFIRM_DELETE_URL}" title="{PHP.L.Delete}" class="btn btn-danger"><span class="fa fa-trash-o"></span>{PHP.L.Delete}</a>
				</div>
			</div>			
				
		</div>
	</div>
</div>
<!-- END: ROW -->
<div class="row"> <!-- Pagination -->
	<div class="col-md-12">
		<!-- IF {PAGENAV_COUNT} > 0 -->							
			<div class="alert alert-warning">{PHP.L.Total}: {PAGENAV_COUNT}</div>
			<!-- IF {PAGENAV_PAGES} -->					
				<ul class="pagination">{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul>		
			<!-- ENDIF -->
		<!-- ELSE -->
			<div class="alert alert-warning">{PHP.L.Noitemsfound}</div>
		<!-- ENDIF -->
	</div>
</div>
<!-- END: MAIN -->
