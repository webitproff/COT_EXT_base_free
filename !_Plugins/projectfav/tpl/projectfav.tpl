<!-- BEGIN: MAIN -->
<div class="breadcrumb">{BREADCRUMBS}</div>
<h1>
	{PHP.L.projectfav}
</h1>

<div class="row">
	<div class="span12">
		<div id="listprojectfav">
			<!-- BEGIN: PRJ_ROWS -->
			<div class="media<!-- IF {PRJ_ROW_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {PRJ_ROW_ISTOP} --> well prjtop<!-- ENDIF -->">
				<h4>
					<!-- IF {PRJ_ROW_COST} > 0 --><div class="pull-right">{PRJ_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
					<a href="{PRJ_ROW_URL}"> {PRJ_ROW_SHORTTITLE}
          </a>
				</h4>
				<p class="owner small">{PRJ_ROW_OWNER_NAME} <span class="date">[{PRJ_ROW_DATE}]</span>   <span class="region">{PRJ_ROW_COUNTRY} {PRJ_ROW_REGION} {PRJ_ROW_CITY}</span>   {PRJ_ROW_EDIT_URL}</p>
				<p class="text">
          {PRJ_ROW_SHORTTEXT}
          {PRJ_ROW_PFS}
        </p>

				<!-- IF {PHP.cot_plugins_active.tags} AND {PHP.cot_plugins_active.tagslance} AND {PHP.cfg.plugin.tagslance.projects} -->
				<p class="small">{PHP.L.Tags}:
					<!-- BEGIN: PRJ_ROW_TAGS_ROW --><!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PRJ_ROW_TAGS_ROW_URL}" title="{PRJ_ROW_TAGS_ROW_TAG}" rel="nofollow">{PRJ_ROW_TAGS_ROW_TAG}</a><!-- END: PRJ_ROW_TAGS_ROW -->
					<!-- BEGIN: PRJ_ROW_NO_TAGS -->{PRJ_ROW_NO_TAGS}<!-- END: PRJ_ROW_NO_TAGS -->
				</p>
				<!-- ENDIF -->

				<div class="pull-right offers"><a href="{PRJ_ROW_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({PRJ_ROW_OFFERS_COUNT})</div>
				<div class="type"><!-- IF {PHP.cot_plugins_active.paypro} AND {PRJ_ROW_FORPRO} --><span class="label label-important">{PHP.L.paypro_forpro}</span> <!-- ENDIF --><!-- IF {PRJ_ROW_TYPE} -->{PRJ_ROW_TYPE} / <!-- ENDIF --></div>
			</div>
			<hr/>
			<!-- END: PRJ_ROWS -->
		</div>
		<!-- IF {PAGENAV_COUNT} > 0 -->
		<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
		<!-- ELSE -->
		<div class="alert">{PHP.L.projectfav_empty}</div>
		<!-- ENDIF -->
	</div>
</div>

<!-- END: MAIN -->