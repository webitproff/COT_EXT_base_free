<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{BREADCRUMBS}</div>
	<form action="{LIST_FORM_URL}" id="listedit" method="post" name="listedit">
		{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
		<div class="table-responsive">
		  <table class="table table-hover">
		  	<thead>
		  	      <tr>
		  	        <td>#</td>
				   	<td>{PHP.L.Product}</td>
				   	<td>{PHP.L.Cost}</td>
				   	<td>{PHP.L.Count}</td>
				   	<td>{PHP.L.Action}</td>
		  	      </tr>
		  	    </thead>
		  	    <tbody>
		    	<!-- BEGIN: ROW -->	
				   <tr id="response{AMO_ID}">
					   	<td>#{ROW_PRD_ID}</td>
					   	<td><a href="{ROW_PRD_URL}">{ROW_PRD_SHORTTITLE}</a></td>
					   	<td>{ROW_PRD_COST} {PHP.cfg.payments.valuta}</td>
					   	<td>{ROW_PRD_COUNT_INPUT}</td>
					   	<td>{ROW_PRD_DELETE}<td>
					   	
	   		   		
				   </tr>
		    	<!-- END: ROW -->
		    	<!-- BEGIN: EXTFLD_ROW -->
		    		   <tr>
		    			   	<td colspan="2">{EXTFLD_ROW_TITLE}</td>
		    			   	<td colspan="3">{EXTFLD_ROW}</td>
		    		   </tr>
		    	<!-- END: EXTFLD_ROW -->		    			
				<tbody>
		  </table>
		</div>
		<hr>
		<button class="btn btn-info pull-right">{PHP.L.Save}</button>
	</form>
<!-- END: MAIN -->