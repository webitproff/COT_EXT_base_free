<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.paypaycontacts_buy_title}</div>

<div class="row">
	<div class="span9">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{PAY_FORM_ACTION}" method="post">
			<table class="table">
				<tr>
					<td width="220">{PHP.L.paypaycontacts_costofmonth}:</td>
					<td>{PAY_FORM_COST} {PHP.cfg.plugin.paycontacts.cost} {PHP.cfg.payments.valuta}</td>
				</tr>
				<tr>
					<td>{PHP.L.paypaycontacts_error_months}:</td>
					<td>{PAY_FORM_PERIOD} {PHP.L.paypaycontacts_month}</td>
				</tr>
				<tr>
					<td></td>
					<td><button class="btn btn-success">{PHP.L.paypaycontacts_buy}</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!-- END: MAIN -->