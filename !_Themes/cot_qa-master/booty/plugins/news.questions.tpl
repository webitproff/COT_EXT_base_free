<!-- BEGIN: NEWS -->

<div class="row">
<!-- BEGIN: PAGE_ROW -->
	<div class="span1">
		{PAGE_ROW_OWNER_AVATAR}
	</div>	
	<div class="span8">
		<h4>
			<div class="pull-right">{PAGE_ROW_LIKERATINGS_DISPLAY}</div>
			<a href="{PAGE_ROW_URL}" title="{PAGE_ROW_SHORTTITLE}">{PAGE_ROW_SHORTTITLE}</a>
		</h4>
		<!-- IF {PAGE_ROW_DESC} --><p class="small">{PAGE_ROW_DESC}</p><!-- ENDIF -->

		<div class="textbox">
			{PAGE_ROW_TEXT_CUT}
			<!-- IF {PAGE_ROW_TEXT_IS_CUT} -->{PAGE_ROW_MORE}<!-- ENDIF -->
		</div>
		<p class="tags">
			<!-- BEGIN: PAGE_TAGS -->
			<i class="icon-tags"></i> 
			<!-- BEGIN: PAGE_TAGS_ROW -->
				<!-- IF {PAGE_TAGS_ROW_TAG_COUNT} > 0 -->, <!-- ENDIF --><a href="{PAGE_TAGS_ROW_URL}" title="{PAGE_TAGS_ROW_TAG}" rel="nofollow">{PAGE_TAGS_ROW_TAG}</a>
			<!-- END: PAGE_TAGS_ROW -->
			<!-- END: PAGE_TAGS -->
		</p>
		<div class="clear">
			<p class="small">
				<!-- IF {PAGE_ROW_OWNER} -->{PAGE_ROW_OWNER}<!-- ELSE -->{PHP.L.Guest}<!-- ENDIF --> | {PAGE_ROW_COMMENTS} | {PAGE_ROW_DATE}
			</p>
		</div>
	</div>
	<hr/>
<!-- END: PAGE_ROW -->
</div>

<div class="pagination">
	<ul>
		{PAGE_PAGEPREV}{PAGE_PAGENAV}{PAGE_PAGENEXT}
	</ul>	
</div>

<!-- END: NEWS -->