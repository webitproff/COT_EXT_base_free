<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{BREADCRUMBS}</div>
	<form action="{CANCEL_FORM_URL}" id="cancelorder" method="post" name="cancelorder">		
		<div class="table-responsive">		
		  <table class="table table-hover">
		  	<thead>
		  	      <tr>
				   	<td>
						{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
					   	<div class="alert alert-info">{PHP.L.amarket_cancel_reason}</div>
				   	</td>
		  	      </tr>
		  	    </thead>
		  	    <tbody>
				   <tr>
					   	<td>{CANCEL_FORM_TEXT}</td>
				   </tr>	    			
				<tbody>
		  </table>
		</div>
		<hr>
		<button class="btn btn-danger pull-right">{PHP.L.Save}</button>
	</form>
<!-- END: MAIN -->
