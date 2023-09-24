<!-- BEGIN: MAIN -->
<diw class="row">
	{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
	<div class="row">
		<div class="span3">
			 {PHP.L.cc_title}
		</div>
		<div class="span3">
			 {PHP.L.cc_desc}			 
		</div>
		<div class="span2">
			 {PHP.L.cc_rownum}	
		</div>
		<div class="span2">
			 {PHP.L.cc_allowgroups}	
		</div>
		<div class="span2">
			 {PHP.L.cc_actions}	
		</div>
	</div>
	<!-- BEGIN: CC_ROW -->
		<hr>
		<div class="row">
			<div class="span3">
				 {CC_ROW_NAME}
			</div>
			<div class="span3">
				<p  title='{CC_ROW_DESC|htmlspecialchars($this)}'>{CC_ROW_DESC|cot_string_truncate($this,150)}</p>
			</div>
			<div class="span2">
				 {CC_ROW_NUMROW}
			</div>
			<div class="span2">
				 {CC_ROW_GROUP}
			</div>
			<div class="span2">
				<div class="btn-group" role="group">
				   <a class="btn btn-success" title="{PHP.L.Edit}" href="{CC_ROW_ID|cot_url('admin', 'm=other&p=costcalculator&n=configcalc&cc_id=$this')}"><i class="icon-tasks" ></i></a>
				  <a class="btn btn-info" title="{PHP.L.Edit}" href="{CC_ROW_ID|cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc&id=$this')}"><i class="icon-edit" ></i></a>
				  <a class="btn btn-danger" title="{PHP.L.Delete}" href="{CC_ROW_ID|cot_url('admin', 'm=other&p=costcalculator&a=delete&id=$this')|cot_confirm_url($this,'costcalculator')}"><i class="icon-remove" ></i></a>
				</div>
			</div>
		</div>	
	<!-- END: CC_ROW -->	
	<hr>
	<div class="span12">
		<a class="btn btn-success" href="{PHP|cot_url('admin', 'm=other&p=costcalculator&n=addeditcalc')}">{PHP.L.Add}</a>
	</div>
</diw>
<!-- END: MAIN -->