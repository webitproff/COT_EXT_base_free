<!-- BEGIN: MAIN -->
<div class="container">
 <div class="row">
	<div class="span12">
    {FORM}
	</div>
 </div>
 <div class="row">
   <!-- BEGIN: SEARCH -->
    <div class="span12">
     <!-- BEGIN: PAGE -->
				<h3><a href="{PAGE_ROW_URL}">{PAGE_ROW_SHORTTITLE}</a></h3>
				<!-- IF {PAGE_ROW_DESC} --><p class="small marginbottom10">{PAGE_ROW_DESC}</p><!-- ENDIF -->
				<div>
					{PAGE_ROW_TEXT_CUT}
					<!-- IF {PAGE_ROW_TEXT_IS_CUT} -->{PAGE_ROW_MORE}<!-- ENDIF -->
				</div>
     <!-- END: PAGE -->
     <!-- BEGIN: MARKET -->
  			<div class="media">
  				<!-- IF {MARKET_ROW_MAVATAR.1} -->
  				<div class="pull-left">
  					<a href="{MARKET_ROW_URL}"><div class="thumbnail"><img src="{MARKET_ROW_MAVATAR.1|cot_mav_thumb($this, 100, 100, crop)}" /></div></a>
  				</div>
  				<!-- ENDIF -->
  				<h4><!-- IF {MARKET_ROW_COST} > 0 --><div class="cost pull-right">{MARKET_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF --><a href="{MARKET_ROW_URL}">{MARKET_ROW_SHORTTITLE}</a></h4>
  				<p class="owner">{MARKET_ROW_OWNER_NAME} <span class="date">[{MARKET_ROW_DATE}]</span> &nbsp;{MARKET_ROW_COUNTRY} {MARKET_ROW_REGION} {MARKET_ROW_CITY} &nbsp; {MARKET_ROW_EDIT_URL}</p>
  				<p class="text">{MARKET_ROW_SHORTTEXT}</p>
  				<p class="type"><a href="{MARKET_ROW_CATURL}">{MARKET_ROW_CATTITLE}</a></p>
  			</div>
     <!-- END: MARKET -->
     <!-- BEGIN: PROJECTS -->
  			<div class="media<!-- IF {PROJECTS_ROW_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {PROJECTS_ROW_ISTOP} --> well prjtop<!-- ENDIF -->">
  				<h4>
  					<!-- IF {PROJECTS_ROW_COST} > 0 --><div class="pull-right">{PROJECTS_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
  					<a href="{PROJECTS_ROW_URL}"> {PROJECTS_ROW_SHORTTITLE}
            </a>
  				</h4>
  				<p class="owner small">{PROJECTS_ROW_OWNER_NAME} <span class="date">[{PROJECTS_ROW_DATE}]</span>   <span class="region">{PROJECTS_ROW_COUNTRY} {PROJECTS_ROW_REGION} {PROJECTS_ROW_CITY}</span>   {PROJECTS_ROW_EDIT_URL}</p>
  				<p class="text">
            {PROJECTS_ROW_SHORTTEXT}
            {PROJECTS_ROW_PFS}
          </p>
  				<div class="pull-right offers"><a href="{PROJECTS_ROW_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({PROJECTS_ROW_OFFERS_COUNT})</div>
  				<div class="type"><!-- IF {PHP.cot_plugins_active.paypro} AND {PROJECTS_ROW_FORPRO} --><span class="label label-important">{PHP.L.paypro_forpro}</span> <!-- ENDIF --><!-- IF {PROJECTS_ROW_TYPE} -->{PROJECTS_ROW_TYPE} / <!-- ENDIF --><a href="{PROJECTS_ROW_CATURL}">{PROJECTS_ROW_CATTITLE}</a></div>
  			</div>
     <!-- END: PROJECTS -->
     <!-- BEGIN: DEMANDS -->
  			<div class="media<!-- IF {DEMANDS_ROW_ISBOLD} --> well prjbold<!-- ENDIF --><!-- IF {DEMANDS_ROW_ISTOP} --> well prjtop<!-- ENDIF -->">
  				<h4>
  					<!-- IF {DEMANDS_ROW_COST} > 0 --><div class="pull-right">{DEMANDS_ROW_COST} {PHP.cfg.payments.valuta}</div><!-- ENDIF -->
  					<a href="{DEMANDS_ROW_URL}"> {DEMANDS_ROW_SHORTTITLE}
            </a>
  				</h4>
  				<p class="owner small">{DEMANDS_ROW_OWNER_NAME} <span class="date">[{DEMANDS_ROW_DATE}]</span>   <span class="region">{DEMANDS_ROW_COUNTRY} {DEMANDS_ROW_REGION} {DEMANDS_ROW_CITY}</span>   {DEMANDS_ROW_EDIT_URL}</p>
  				<p class="text">
            {DEMANDS_ROW_SHORTTEXT}
            {DEMANDS_ROW_PFS}
          </p>
  				<div class="pull-right offers"><a href="{DEMANDS_ROW_OFFERS_ADDOFFER_URL}">{PHP.L.offers_add_offer}</a> ({DEMANDS_ROW_OFFERS_COUNT})</div>
  				<div class="type"><!-- IF {PHP.cot_plugins_active.paypro} AND {DEMANDS_ROW_FORPRO} --><span class="label label-important">{PHP.L.paypro_forpro}</span> <!-- ENDIF --><!-- IF {DEMANDS_ROW_TYPE} -->{DEMANDS_ROW_TYPE} / <!-- ENDIF --><a href="{DEMANDS_ROW_CATURL}">{DEMANDS_ROW_CATTITLE}</a></div>
  			</div>
     <!-- END: DEMANDS -->
    </div>
   <!-- END: SEARCH -->
  </div>
</div>
<!-- END: MAIN -->