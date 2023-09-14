<!-- BEGIN: MAIN -->
<div class="timeline-centered">

<!-- BEGIN: TIMELINE -->    
	<article class="timeline-entry<!-- IF {TIMELINE_ROW_ODDEVEN} == 'odd' --> left-aligned<!-- ENDIF -->">		
		<div class="timeline-entry-inner">
			<time class="timeline-time"><span>{TIMELINE_ROW_DATE_STAMP|cot_build_timegap()} назад</span> <small class="muted" style="font-size: 70%;">{TIMELINE_ROW_DATE}</small></time>
			
      <!-- IF {TIMELINE_ROW_EXT} == 'projects' -->

        <!-- IF {TIMELINE_ROW_TYPE} == 'offers_add' OR {TIMELINE_ROW_TYPE} == 'add' -->
			   <div class="timeline-icon bg-success">
				  <i class="icon-plus icon-white"></i>
			   </div>
        <!-- ENDIF -->
        <!-- IF {TIMELINE_ROW_TYPE} == 'offers_performer' OR {TIMELINE_ROW_TYPE} == 'offers_setperformer' -->
			   <div class="timeline-icon bg-warning">
				  <i class="icon-check icon-white"></i>
			   </div>
        <!-- ENDIF -->      
        <!-- IF {TIMELINE_ROW_TYPE} == 'offers_refuse' -->
			   <div class="timeline-icon bg-primary">
				  <i class="icon-remove icon-white"></i>
			   </div>
        <!-- ENDIF -->
      
			<!-- ENDIF -->

      <!-- IF {TIMELINE_ROW_EXT} == 'folio' OR {TIMELINE_ROW_EXT} == 'market'-->
			<div class="timeline-icon bg-success">
				<i class="icon-plus icon-white"></i>
			</div>
			<!-- ENDIF -->
      
      <!-- IF {TIMELINE_ROW_EXT} == 'reviews' -->
			<div class="timeline-icon bg-info">
				<i class="icon-comment icon-white"></i>
			</div>
			<!-- ENDIF -->    
      
      <!-- IF {TIMELINE_ROW_EXT} == 'paypro' OR {TIMELINE_ROW_EXT} == 'paytop' OR {TIMELINE_ROW_EXT} == 'payprjbold' OR {TIMELINE_ROW_EXT} == 'payprjtop'-->
			<div class="timeline-icon bg-secondary">
				<i class="icon-gift icon-white"></i>
			</div>
			<!-- ENDIF -->      

      <!-- IF {TIMELINE_ROW_EXT} == 'forums'-->
			<div class="timeline-icon bg-success">
				<i class="icon-tasks icon-white"></i>
			</div>
			<!-- ENDIF --> 
            
			<div class="timeline-label">
				<h2 class="margin0">{TIMELINE_ROW_TEXT}</h2>
        {TIMELINE_ROW_INFO}
			</div>
		</div>		
	</article>
<!-- END: TIMELINE -->
<!-- BEGIN: REGISTRATION -->	
	<article class="timeline-entry begin">	
		<div class="timeline-entry-inner">			
			<div class="timeline-icon">
				<i class="icon-ok-sign"></i>
			</div>			
		</div>
    <p class="timeline-register-text">{PHP.L.timeline_users_register_details}</p>		
	</article>
<!-- END: REGISTRATION -->	
</div>
<!-- END: MAIN -->