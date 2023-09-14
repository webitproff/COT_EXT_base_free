<!-- BEGIN: MAIN -->
<div style="font-size: 14px;font-weight: normal;">
		<!-- IF {PRD_COST} > 0 --><p>{PHP.L.offers_budget}: {PRD_COST} {PHP.cfg.payments.valuta}</p><!-- ENDIF -->
		<p class="cat">{PHP.L.Category} : <a href="{PRD_CAT|cot_url('projects', 'c='$this)}">{PRD_CATTITLE}</a></p>
		<p class="date">{PHP.L.Date}: {PRD_DATE}</p>
		
		<!-- IF {PHP.cot_plugins_active.tags} AND {PHP.cot_plugins_active.tagslance} AND {PHP.cfg.plugin.tagslance.projects} -->
		<p class="small">{PHP.L.Tags}: 
			<!-- BEGIN: PRJ_TAGS_ROW --><!-- IF {PHP.tag_i} > 0 -->, <!-- ENDIF --><a href="{PRD_TAGS_ROW_URL}" title="{PRD_TAGS_ROW_TAG}" rel="nofollow">{PRD_TAGS_ROW_TAG}</a><!-- END: PRJ_TAGS_ROW -->
			<!-- BEGIN: PRJ_NO_TAGS -->{PRD_NO_TAGS}<!-- END: PRJ_NO_TAGS -->
		</p>
		<!-- ENDIF -->
<div>
<!-- END: MAIN -->