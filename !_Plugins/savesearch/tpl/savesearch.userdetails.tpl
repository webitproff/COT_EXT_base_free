<!-- BEGIN: MAIN -->
<h5>{PHP.L.savesearch}</h5>

<div id="listsavesearch" class="mt-md">
	<!-- BEGIN: S_ROWS -->
	<div>
    <a href="{S_HREF}">{PHP.L.savesearch_savedsearch} {S_CODE_TEXT}</a>
	</div>
	<hr/>
	<!-- END: S_ROWS -->
</div>

<!-- IF {SS_СOUNT} == 0 -->
<div class="alert">{PHP.L.savesearch_empty}</div>
<!-- ENDIF -->

<!-- END: MAIN -->