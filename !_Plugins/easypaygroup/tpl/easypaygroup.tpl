<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.easypaygroup_buy_title} "{EASYPAY_FORM_NAME}"</div>

<div class="row">
	<div class="span9">
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<form action="{EASYPAY_FORM_ACTION}" method="post">
			<table class="table">
				<tr>
					<td width="220">{PHP.L.easypaygroup_time}:</td>
					<td>{EASYPAY_FORM_TIME}</td>
				</tr>
				<tr>
					<td width="220">{PHP.L.easypaygroup_cost}:</td>
					<td>{EASYPAY_FORM_COST} {PHP.cfg.payments.valuta}</td>
				</tr>
				<!-- IF {PHP.usr.id} == 0 -->
				<tr>
					<td width="220">{PHP.L.easypaygroup_email}:</td>
					<td>{EASYPAY_FORM_EMAIL}</td>
				</tr>
				<!-- ENDIF -->
				<tr>
					<td></td>
					<td><button class="btn btn-success">{PHP.L.easypaygroup_buy}</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!-- END: MAIN -->