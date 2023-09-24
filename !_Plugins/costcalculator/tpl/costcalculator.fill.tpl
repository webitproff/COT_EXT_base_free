<!-- BEGIN: MAIN -->
<div class="content">
	<div class="breadcrumb">{BREADCRUMBS}</div>
	<div class="row">
		<div class="span3">
			<h4>{CC_NAME}</h4>
			<span>{CC_DESC}</span>			
		</div>	
		<div class="span9">
			{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
			<form action="{FORM_ACTION}" method="post" class="ajax post-resp_{CC_ID}" id="cc{CC_ID}">
				<input type="hidden" name="cc_id" value="{CC_ID}" >
			<!-- BEGIN: CCR_ROW -->		
				<div class="row">
					<div class="span5">
						{CCR_ROW_NAME} <span class="red">*</span>
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
					<div class="span6" id="resp_{CC_ID}">
					<!-- Результат роботи -->
					</div>
					<div class="span1">
						 <!-- IF {CC_DELETE_URL}  -->
							<a href="{CC_DELETE_URL}" class="btn btn-warning">{PHP.L.Delete}</a>
						 <!-- ENDIF -->
					</div>
					<div class="span2">
						<input type="submit" class="btn btn-success" value="{PHP.L.Submit}">
					</div>
				</div>
			</form>
		</div>
	</div>		
</div>
<!-- END: MAIN -->


CCR_ROW_ID'  => $row['ccr_id'],
		'CCR_ROW_NAME'  => $row['ccr_name'],
		'CCR_ROW_DESC'  => $row['ccr_desc'],
		'CCR_ROW_INPUT'  => cot_inputbox('text', '$inp[{$row["ccr_id"]}]', 0, array('size' => 4, 'maxlength' => 50)),
		'CCR_ROW_UNITS