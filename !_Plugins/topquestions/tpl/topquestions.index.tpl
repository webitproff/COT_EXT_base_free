<!-- BEGIN: MAIN -->

	<h4>{PHP.L.topquestions}</h4>
	<div class="well" style="max-width: 340px; padding: 8px 0;">
		<ul class="nav nav-list">
			<!-- BEGIN: TOPQ_ROW -->
			<li>
				<a href="{TOPQ_ROW_URL}">{TOPQ_ROW_CUTTITLE} <span class="pull-right badge badge-success">{TOPQ_ROW_RATING}</span></a>
			</li>
			<!-- IF {TOPQ_ROW_DIVIDER} --><li class="divider"></li><!-- ENDIF -->
			<!-- END: TOPQ_ROW -->
		</ul>
	</div>

<!-- END: MAIN -->