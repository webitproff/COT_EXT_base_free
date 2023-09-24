<!-- BEGIN: MAIN -->
	<div class="container">
		<div class="row">	
				{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
				<!-- BEGIN: PO_ROW -->
					<div class="col-sm-6 col-md-4 span4 text-center centerall">
					  <div class="thumbnail">
					    <img src="https://api.fnkr.net/testimg/300/00CED1/FFF/?text=img+placeholder" alt="...">
					    <div class="caption">
					      <h3>{PO_ROW_COUNT} Предложений</h3>
					      <p>{PO_ROW_COST} {PHP.cfg.payments.valuta}</p>
					       <p><a href="{PO_ROW_PAY_URL}" class="btn btn-primary" role="button">Купить</a></p>
					       <p><a href="{PO_ROW_PAY_CONFIRM_URL}" class="btn btn-primary" role="button">Купить</a></p>
					    </div>
					  </div>
					</div>				
				<!-- END: PO_ROW -->
		</div>
	</div>
<!-- END: MAIN -->
