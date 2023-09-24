<!-- BEGIN: MAIN -->
	<div class="breadcrumb">{BREADCRUMBS}</div>
	<div class="tabbable"> 
	  <ul class="nav nav-tabs">
	    <li <!-- IF {PHP.n} == 'forconfirm' -->class="active"<!-- ENDIF -->><a href="{AMARKET_MYSALES_FORCONFIRM}">{PHP.L.amarket_status_forconfirm_title} <span class="label label-info">{AMARKET_MYSALES_FORCONFIRM_COUNT}</span></a></li>
	    <li <!-- IF {PHP.n} == 'waitpayment' -->class="active"<!-- ENDIF -->><a href="{AMARKET_MYSALES_WAITPAYMENT}">{PHP.L.amarket_status_waitpayment_title} <span class="label label-info">{AMARKET_MYSALES_WAITPAYMENT_COUNT}</span></a></li>
	    <li <!-- IF {PHP.n} == 'paid' -->class="active"<!-- ENDIF -->><a href="{AMARKET_MYSALES_PAID}">{PHP.L.amarket_status_paid_title} <span class="label label-info">{AMARKET_MYSALES_PAID_COUNT}</span></a></li>
	    <li <!-- IF {PHP.n} == 'cancelled' -->class="active"<!-- ENDIF -->><a href="{AMARKET_MYSALES_CANCELLED}">{PHP.L.amarket_status_cancelled_title} <span class="label label-info">{AMARKET_MYSALES_CANCELLED_COUNT}</span></a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active">
	   		{FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
	      	{AMARKET}

	      <!-- IF {PAGENAV_COUNT} > 0 -->	
	     	<div class="pagination"><ul>{PAGENAV_PAGES}</ul></div>
	     	{PAGENAV_ONPAGE} {PHP.L.Of} {PAGENAV_COUNT}
	      <!-- ELSE -->
	      	<div class="alert">{PHP.L.Noitemsfound}</div>
	      <!-- ENDIF -->
	    </div>
	  </div>
	</div>

<!-- END: MAIN -->
