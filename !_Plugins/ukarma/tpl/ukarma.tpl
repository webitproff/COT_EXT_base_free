<!-- BEGIN: MAIN -->

<span id="{UKARMA_SELECTOR}">
	<b>{UKARMA_SIGN} {UKARMA_SCORE_ABS}</b>
	<!-- IF {UKARMA_SCOREENABLED} -->
	<a href="index.php?r=ukarma&m=add&userid={UKARMA_USER_ID}&area={UKARMA_AREA}&code={UKARMA_CODE}&score=-1" class="ajax" rel="get-{UKARMA_SELECTOR}">[-]</a> 
	<a href="index.php?r=ukarma&m=add&userid={UKARMA_USER_ID}&area={UKARMA_AREA}&code={UKARMA_CODE}&score=1" class="ajax" rel="get-{UKARMA_SELECTOR}">[+]</a>
	<!-- ELSE -->
	
	<!-- ENDIF -->
</span>

<!-- END: MAIN -->