<!-- BEGIN: MAIN -->

<div class="breadcrumb">{BREADCRUMBS}</div>
<div class="pull-right paddingtop10"><span class="label label-info">{ORDER_LOCALSTATUS}</span></div>
<h1>{PHP.L.tiuorders_title} № {ORDER_ID}</h1>
<div class="customform">
	<table class="table">
		<tr>
			<td align="right" style="width:176px;">{PHP.L.tiuorders_product}:</td>
			<td><!-- IF {ORDER_PRD_SHORTTITLE} --><a href="{ORDER_PRD_URL}" target="blank">[ID {ORDER_PRD_ID}] {ORDER_PRD_SHORTTITLE}</a><!-- ELSE -->{ORDER_TITLE}<!-- ENDIF --></td>
		</tr>
		<tr>
			<td align="right">{PHP.L.tiuorders_count}:</td>
			<td>{ORDER_COUNT}</td>
		</tr>
		<tr>
			<td align="right">{PHP.L.tiuorders_comment}:</td>
			<td>{ORDER_COMMENT}</td>
		</tr>
		<tr>
			<td align="right">{PHP.L.tiuorders_cost}:</td>
			<td>{ORDER_COST} {PHP.cfg.payments.valuta}</td>
		</tr>
		<tr>
			<td align="right">{PHP.L.tiuorders_paid}:</td>
			<td>{ORDER_PAID|date('d.m.Y H:i', $this)}</td>
		</tr>
		<tr>
			<td align="right">{PHP.L.tiuorders_warranty}:</td>
			<td>{ORDER_WARRANTYDATE|date('d.m.Y H:i', $this)}</td>
		</tr>
		<!-- IF {ORDER_DOWNLOAD} -->
		<tr>
			<td align="right">{PHP.L.tiuorders_file_for_download}:</td>
			<td><a href="{ORDER_DOWNLOAD}" >{PHP.L.tiuorders_file_download}</a></td>
		</tr>
		<!-- ENDIF -->
	</table>
	<!-- IF {ORDER_WARRANTYDATE} > {PHP.sys.now} AND {ORDER_STATUS} == 'paid' AND {PHP.usr.id} == {ORDER_CUSTOMER_ID} -->
	<a class="btn btn-warning" href="{ORDER_ID|cot_url('tiuorders', 'm=addclaim&id='$this)}">{PHP.L.tiuorders_addclaim_button}</a>
	<!-- ENDIF -->
	
	<!-- BEGIN: CLAIM -->
	<h3>{PHP.L.tiuorders_claim_title}</h3>
	<div class="well">
		<div class="pull-right">{CLAIM_DATE|date('d.m.Y H:i', $this)}</div>
		<p>{CLAIM_TEXT}</p>

		<!-- BEGIN: ADMINCLAIM -->
		<p>
			<a href="{ORDER_ID|cot_url('tiuorders', 'a=acceptclaim&id='$this)}" class="btn btn-warning">{PHP.L.tiuorders_claim_accept}</a>
			<a href="{ORDER_ID|cot_url('tiuorders', 'a=cancelclaim&id='$this)}" class="btn btn-danger">{PHP.L.tiuorders_claim_cancel}</a>
		</p>
		<!-- END: ADMINCLAIM -->
	</div>
	<!-- END: CLAIM -->
	
</div>

<!-- END: MAIN -->