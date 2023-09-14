<!-- BEGIN: MAIN -->
	<div id="GeoModal" class="modal hide fade">
		<div class="modal-header">
    <div class="pull-right">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">{PHP.L.Close}</button>
      </div>
			<h3 id="myModalLabel">{PHP.L.select_city}</h3>
			</div>
			<div class="modal-body textcenter">
				<form id="GeoForm" class="form-horizontal" action="{GEOTARGETING_SUBMIT}" method="post">
         <input type="hidden" name="geo" value="update"/>
					<div class="control-group">
          	{GEOTARGETING_SEARCH}
					</div>
			</div>
			<div class="modal-footer textcenter">
      <button type="submit" class="btn btn-primary btn-large">{PHP.L.Save}</button>
      	</form>
		</div>
	</div>
<!-- END: MAIN -->