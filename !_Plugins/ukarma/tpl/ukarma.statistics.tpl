<!-- BEGIN: MAIN -->

<table class="table">
	<thead>
	<tr>
		<th>{PHP.L.Date}</th>
		<th>{PHP.L.User}</th>
		<th>{PHP.L.Page}</th>
		<th>{PHP.L.Value}</th>
	</tr>
	</thead>
	<tbody>
	<!-- BEGIN: UKARMA_ROW -->
	<tr>
		<td>{UKARMA_ROW_DATE|date('d.m.Y H:i', $this)}</td>
		<td>{UKARMA_ROW_OWNER_NAME}</td>
		<td><a href="{UKARMA_ROW_URL}">{UKARMA_ROW_TITLE}</a></td>
		<td>{UKARMA_ROW_SIGN}{UKARMA_ROW_SCORE}</td>
	</tr>
	<!-- END: UKARMA_ROW -->
	</tbody>
</table>
<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>

<!-- END: MAIN -->