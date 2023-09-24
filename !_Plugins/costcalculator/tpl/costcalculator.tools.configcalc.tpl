<!-- BEGIN: MAIN -->
<div>
{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
	<div class="row">
		<form class="form-inline" action="{CCR_ROWS_ACTION_UPDATE}" method="POST" id="cc_form">
			<div class="span12">
				<div class="row">
					<div class="span1">
						№
					</div>
					<div class="span4">
						{PHP.L.cc_title}
					</div>
					<div class="span4">
						{PHP.L.cc_desc}	
					</div>
					<div class="span2">
						{PHP.L.cc_units}
					</div>
					<div class="span1">
						{PHP.L.Delete}						
					</div>
				</div>
				
				<!-- BEGIN: CCR_ROW -->			
				<div class="row">
					<div class="span1">
						{CCR_ROW_ORDER}
					</div>
					<div class="span4">
						{CCR_ROW_NAME}
					</div>
					<div class="span4">
						{CCR_ROW_DESC}
					</div>
					<div class="span2">
						{CCR_ROW_UNITS}
					</div>
					<div class="span1">
						<a class="btn btn-danger" title="{PHP.L.Delete}" href="{CCR_ROW_DELETE}"><i class="icon-remove" ></i></a>						
					</div>
				</div>
				<hr>
				<!-- END: CCR_ROW -->
				<!-- IF {CCR_ROWS_COUNT} > 0 -->
				<div class="row">
					<div class="span12">
						<button type="submit" class="btn btn-success">{PHP.L.Save}</button>
						<a href="{PHP.cc_id|cot_url('costcalculator','id=$this')}" class="btn btn-warning pull-right">{PHP.L.Open}</a>
					</div>
				</div>
				<!-- ENDIF -->
			</div>
		</form>
	</div>
	<hr>
	<div class="row">
		<form class="form-inline" action="{CCR_FORM_ACTION}" method="POST" id="ccr_form">
			<div class="span1">
				{CCR_ORDER}				
			</div>
			<div class="span4">
				{CCR_NAME}
			</div>
			<div class="span4">
			  	{CCR_DESC}			  	
			</div>
			<div class="span2">
				{CCR_UNITS}				
			</div>
			<div class="span1">
				<button type="submit" class="btn btn-primary">{PHP.L.Add}</button>
			</div>
		</form>
	</div>

</div>
<!-- END: MAIN -->