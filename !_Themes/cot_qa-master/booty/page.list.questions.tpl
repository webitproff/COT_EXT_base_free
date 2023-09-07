<!-- BEGIN: MAIN -->

<div class="breadcrumb">{LIST_CATPATH}</div>
<h1>{LIST_CATTITLE}</h1>
<div class="row">
	<div class="span9">
		<div class="block">
		<!-- BEGIN: LIST_ROW -->
			<div class="row">
				<div class="span1">
					{LIST_ROW_OWNER_AVATAR}
				</div>
				<div class="span8">
					<h4>
					<div class="pull-right">{LIST_ROW_LIKERATINGS_DISPLAY}</div>
						<a href="{LIST_ROW_URL}">{LIST_ROW_SHORTTITLE}</a>
					</h4>
					<p class="small">
						<!-- IF {LIST_ROW_OWNER} -->{LIST_ROW_OWNER}<!-- ELSE -->{PHP.L.Guest}<!-- ENDIF --> | {LIST_ROW_COMMENTS} | {LIST_ROW_DATE}
					</p>
					<!-- IF {LIST_ROW_DESC} --><p class="small marginbottom10">{LIST_ROW_DESC}</p><!-- ENDIF -->
					<!-- IF {PHP.usr.isadmin} --><p class="small marginbottom10">{LIST_ROW_ADMIN} ({LIST_ROW_COUNT})</p><!-- ENDIF -->
					<div>
						{LIST_ROW_TEXT_CUT}
						<!-- IF {LIST_ROW_TEXT_IS_CUT} -->{LIST_ROW_MORE}<!-- ENDIF -->
					</div>
					<p class="tags">
						<i class="icon-tags"></i> 
						<!-- BEGIN: LIST_ROW_TAGS_ROW -->
							<!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{LIST_ROW_TAGS_ROW_URL}" title="{LIST_ROW_TAGS_ROW_TAG}" rel="nofollow">{LIST_ROW_TAGS_ROW_TAG}</a>
						<!-- END: LIST_ROW_TAGS_ROW -->
					</p>
				</div>
			</div>	
			<hr class="clear divider" />
		<!-- END: LIST_ROW -->
		</div>
		<!-- IF {LIST_TOP_PAGINATION} -->
		<div class="pagination">
			<ul>
				{LIST_TOP_PAGEPREV}{LIST_TOP_PAGINATION}{LIST_TOP_PAGENEXT}
			</ul>
		</div>
		<!-- ENDIF -->
	</div>

	<div class="span3">
		<a href="<!-- IF {PHP.c|cot_auth('page', $this, 'W')} > 0 -->{PHP.c|cot_url('page','m=add&c='$this)}<!-- ELSE -->{PHP|cot_url('login')}<!-- ENDIF -->" class="btn btn-primary btn-block btn-large">{PHP.L.question_add}</a>
		<br/>
		
		<ul class="nav nav-pills nav-stacked">
		<!-- BEGIN: LIST_ROWCAT -->
			<li><a href="{LIST_ROWCAT_URL}" title="{LIST_ROWCAT_TITLE}">{LIST_ROWCAT_TITLE} {LIST_ROWCAT_COUNT}</a></li>
		<!-- END: LIST_ROWCAT -->
		</ul>
		
		<!-- IF {PHP.cot_plugins_active.tags} -->
		<div class="block">
			<div class="mboxHD tags">{PHP.L.Tags}</div>
			{LIST_TAG_CLOUD}
		</div>
		<!-- ENDIF -->
	</div>
</div>

<!-- END: MAIN -->