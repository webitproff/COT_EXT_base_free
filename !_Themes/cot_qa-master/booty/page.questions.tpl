<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PAGE_CATPATH} / {PAGE_SHORTTITLE}</div>
<div class="row">
	<div class="span9">
		<div class="row">
			<div class="span1">
				{PAGE_OWNER_AVATAR}
			</div>	
			<div class="span8">
				<h1>
				<div class="pull-right">{PAGE_LIKERATINGS_DISPLAY}</div>{PAGE_SHORTTITLE}</h1>
				<div class="clear textbox">{PAGE_TEXT}</div>
				<div class="tags">
					<i class="icon-tags"></i> 
					<!-- BEGIN: PAGE_TAGS_ROW -->
					<!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PAGE_TAGS_ROW_URL}" title="{PAGE_TAGS_ROW_TAG}" rel="nofollow">{PAGE_TAGS_ROW_TAG}</a>
					<!-- END: PAGE_TAGS_ROW -->
					<!-- BEGIN: PAGE_NO_TAGS -->
					{PAGE_NO_TAGS}
					<!-- END: PAGE_NO_TAGS -->
				</div>
			</div>
		</div>
		<hr/>
		{PAGE_COMMENTS_DISPLAY}
	</div>
	<div class="span3">
	<!-- BEGIN: PAGE_ADMIN -->
		<div class="block">
			<div class="mboxHD admin">{PHP.L.Adminpanel}</div>
			<ul class="nav nav-tabs nav-stacked">
				<!-- IF {PHP.usr.isadmin} -->
				<li><a href="{PHP|cot_url('admin')}">{PHP.L.Adminpanel}</a></li>
				<!-- ENDIF -->
				<li><a href="{PAGE_CAT|cot_url('page','m=add&c=$this')}">{PHP.L.question_add}</a></li>
				<li>{PAGE_ADMIN_UNVALIDATE}</li>
				<li>{PAGE_ADMIN_EDIT}</li>
				<li>{PAGE_ADMIN_DELETE}</li>
			</ul>
		</div>
	<!-- END: PAGE_ADMIN -->
	<!-- BEGIN: PAGE_MULTI -->
		<div class="block">
			<div class="mboxHD info">{PHP.L.Summary}:</div>
			{PAGE_MULTI_TABTITLES}
			<p class="paging">{PAGE_MULTI_TABNAV}</p>
		</div>
	<!-- END: PAGE_MULTI -->
	</div>
</div>

<!-- END: MAIN -->