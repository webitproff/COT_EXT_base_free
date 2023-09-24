<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{PHP.L.favoriteusers_title}</div>
	<!-- IF {FAVU_LIMIT_WARNING} -->
	<div class="row">
		<div class="span12">
			<div class="alert alert-warning">{FAVU_LIMIT_WARNING}</div>
		</div>
	</div>
	<!-- ENDIF -->
	<div class="row">
		<div class="span12">		
			<form class="form-inline" method="get" id="favu_form" action="{PHP|cot_url('index')}">
				<input type="hidden" name="e" value="favoriteusers" />
			  	{FAVU_SQ}			  
			  	{FAVU_CAT}
			  	{FAVU_SORT}
			  <button type="submit" class="btn">{PHP.L.Search}</button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="span12">			
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		</div>
	</div>
	
	
	<div class="row">
		<div class="span12">
			<ul class="thumbnails">
				<!-- BEGIN: USER_LIST_ROW -->
					<li class="span3 {USER_LIST_ROW_ODDEVEN}">
					  <div class="thumbnail centerall">
					    {USER_LIST_ROW_AVATAR}
					    <div>
					    {USER_LIST_ROW_NAME}
					    <span class="label label-info">{USER_LIST_ROW_USERPOINTS}</span>
					   	 <!-- IF {USER_LIST_ROW_ISPRO} -->
							<span class="label label-important">PRO</span> 
						 <!-- ENDIF -->
						 </div>
						 <p>{USER_LIST_ROW_USERSELECTED_GROUP_NAME}</p>
					     <p>{USER_LIST_ROW_CATS|cot_usercategories_tree($this,'','list')}</p>
					     <p id="uid{USER_LIST_ROW_ID}">{USER_LIST_ROW_DELETE_URL}</p>
					  </div>
					</li>
				<!-- END: USER_LIST_ROW -->
			</ul>
		</div>
	</div>	

	<div class="row">
		<div class="span12">
			<!-- IF {PAGENAV_COUNT} > 0 -->	
				<div class="pagination"><ul>{PAGENAV_PREV}{PAGENAV_PAGES}{PAGENAV_NEXT}</ul></div>
			<!-- ELSE -->
				<div class="alert">{PHP.L.Noitemsfound}</div>
			<!-- ENDIF -->
		</div>
	</div>


<!-- END: MAIN -->