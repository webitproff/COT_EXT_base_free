<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{BREADCRUMBS}</div>

	<div class="row">
		<div class="span12">
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<form action="{AM_FORM_ACTION}" method="post">
				<table class="table">
					<!-- BEGIN: PRD -->					
						<tr>
							<td>{PRD_TITLE}</td>
							<td>{PRD_COUNT} * {PRD_COST} {PHP.cfg.payments.valuta}</td>
							<td>{PRD_COST_SUMM} {PHP.cfg.payments.valuta}</td>
						</tr>					
					<!-- END: PRD -->
					<tr>
						<td>{PHP.L.Cost_all}</td>
						<td>{AM_CLEAR_COST} {PHP.cfg.payments.valuta}</td>
						<td></td>
					</tr>					
					<tr>
						<td>{PHP.L.Commission}</td>
						<td>{AM_COMM} {PHP.cfg.payments.valuta}</td>
						<td></td>
					</tr>
					<tr>
						<td width="220">{PHP.L.To_pay}:</td>
						<td>{AM_COST} {PHP.cfg.payments.valuta}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><button class="btn btn-success">{PHP.L.Pay_order}</button></td>
						<td></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

<!-- END: MAIN -->
