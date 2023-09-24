<!-- BEGIN: MAIN -->
<style>
	#cart .overflow {
		overflow-y:scroll;
	}
</style>
<hr>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div class="row" id="cart">
	<form action="{USERS_AMARKET_CART_ACTION}" method="post" id="order_cart" name="order_cart">
	<input type="hidden" name="a" value="addOrder">
		<div class="span5">
			<ul class="overflow">
				<!-- BEGIN: ROW -->
					<li>{ROW_PRD_SHORTTITLE} ({ROW_PRD_NEEDCOUNT} * {ROW_PRD_COST} {PHP.cfg.payments.valuta}) - {ROW_PRD_COSTFORNEEDCOUNT} {PHP.cfg.payments.valuta} <a href="{ROW_PRD_DELETE}">{PHP.L.Delete}</a></li>
				<!-- END: ROW -->
				<!-- IF {USERS_AMARKET_PRODUCTS_COUNT} == 0 -->
					<li>{PHP.L.None}</li>
				<!-- ENDIF -->
			</ul>
		</div>
		<div class="span4">
			<!-- BEGIN: EXTF_ROW -->
				{USERS_AMARKET_EXTRAFLD_TITLE}: {USERS_AMARKET_EXTRAFLD}
			<!-- END: EXTF_ROW -->
			<br>
			{PHP.L.Commission}: {USERS_AMARKET_COMMISSION} {PHP.cfg.payments.valuta}<br>
			{PHP.L.To_pay}: {USERS_AMARKET_TOTALPRICE} {PHP.cfg.payments.valuta} <br>
			
			<hr>
			<br>
			<button class="btn btn-info">{PHP.L.Submit}</button>
		</div>
	</form>
</div>
<!-- END: MAIN -->
