<!-- BEGIN: MAIN -->
<div id="ajaxBlock">
	<!-- BEGIN: BODY -->
	<div class="breadcrumb">{ADMIN_BREADCRUMBS}</div>

	<!-- IF {ADMIN_TITLE} -->
	<h1>{ADMIN_TITLE}</h1>
	<!-- ENDIF -->

	<div id="main" class="body clear">
		{ADMIN_MAIN}
		<!-- IF {ADMIN_HELP} -->
		<div class="block">
			<div class="help">
				<h4>{PHP.L.Help}:</h4>
				<p>{ADMIN_HELP}</p>
			</div>
		</div>
		<!-- ENDIF -->
	</div>
<!-- END: BODY -->
</div>
<!-- END: MAIN -->