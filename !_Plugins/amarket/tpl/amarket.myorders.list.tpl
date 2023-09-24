<!-- BEGIN: MAIN -->
<div class="table-responsive">
  <table class="table table-hover">
  	<thead>
  	      <tr>
  	        <td>#</td>
		   	<td>{PHP.L.Added} / {PHP.L.Changed} {AMO_SORT}</td>
		   	<td>{PHP.L.Seller}</td>
		   	<td>{PHP.L.Products}</td>
		   	<td>{PHP.L.Cost}</td>
		   	<td>{PHP.L.Action}</td>
  	      </tr>
  	    </thead>
  	    <tbody>
    	<!-- BEGIN: ROW -->
		   <tr id="response{AMO_ID}">
			   	<td>#{AMO_ID}</td>
			   	<td>{AMO_ADDED} <!-- IF {AMO_CHANGE} != '-' --><br>{AMO_CHANGE}<!-- ENDIF --></td>
			   	<td>{AMO_SELLER_NAME}</td>
			   	<td>
	   		   		<ul>
	   				<!-- BEGIN: PRD -->
	   		   			<li>{PRD_TITLE} {PRD_COST} {PHP.cfg.payments.valuta}  * {PRD_COUNT} = {PRD_COST_SUMM} {PHP.cfg.payments.valuta}</li>
	   		   		<!-- END: PRD -->
	   		   		</ul>

	   		   		{AMO_DELIVER_TITLE}: {AMO_DELIVER|cot_date("- d:m:Y H:i:s",$this)} <br>
	   		   		{AMO_OTHER_TITLE}: {AMO_OTHER}
	   		   		<br>
	   		   		{AMO_COUNT_TITLE}: {AMO_COUNT}

	   		   		<hr>
			   	</td>
			   	<td>
			   		<ul>
			   			<li>{PHP.L.Cost_all}: {AMO_COST} {PHP.cfg.payments.valuta}</li>
			   			<li>{PHP.L.Commission}: {AMO_COMMISSION} {PHP.cfg.payments.valuta}</li>
			   			<li>{PHP.L.To_pay}: {AMO_COST_WC} {PHP.cfg.payments.valuta}</li>
			   		</ul>
			   	</td>
			   	<td>
            		<!-- IF {AMO_INVISIBLE_BTN} -->{AMO_INVISIBLE_BTN}<!-- ENDIF -->
			   		<!-- IF {AMO_CANCEL_BTN} --><div class="btn-group">{AMO_CANCEL_BTN} {AMO_PAY_BTN}</div> <!-- ENDIF -->
					<!-- IF {AMO_CANCEL_REASON} -->{AMO_CANCEL_REASON}<!-- ENDIF -->
			   	</td>
		   </tr>
    	<!-- END: ROW -->
		<tbody>
  </table>
  <!-- IF {AMO_INVISIBLE_BTN_ALL} -->{AMO_INVISIBLE_BTN_ALL}<!-- ENDIF -->
</div>
<!-- END: MAIN -->
