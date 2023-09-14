<!-- BEGIN: MAIN -->

<div id="onliner_widget">
<h4>{PHP.L.WhosOnline} [{STAT_COUNT_USERS}|{STAT_COUNT_GUESTS}]</h4>
<div class="online_widget_list">
	<ul>
	<!-- BEGIN: USERS -->
		<li>
			{USER_NAME}: {USER_SUBLOCATION|cot_cutstring($this, 40)} [{USER_LASTSEEN}]
		</li>
	<!-- END: USERS -->
	</ul>
</div>
</div>

<!-- END: MAIN -->