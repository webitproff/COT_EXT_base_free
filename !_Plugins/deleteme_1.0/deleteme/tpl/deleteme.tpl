<!-- BEGIN: MAIN -->
<div class="breadcrumb">{PHP.L.dm_title}</div>

	<div class="row">
		<div class="span12 centerall">
			{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
			<form action="{DM_ACTION_URL}" method="POST" id="dm">
				<div class="alert alert-info">
					{PHP.L.dm_info}
				</div>
				<div class="well well-small">
					{PHP.L.dm_cost_pay}: <span class="badge badge-warning">{DM_COST_INFO}</span>
				</div>
				<div>
					<button class="btn btn-danger">{PHP.L.Submit}</button>
				</div>
			</form>
		</div>
	</div>

<!-- END: MAIN -->
