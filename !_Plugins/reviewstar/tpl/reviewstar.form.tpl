<!-- BEGIN: MAIN -->   

<!-- BEGIN: ADD -->
<script>
$(document).ready(function() {
  $('.fquality').raty({ scoreName: 'rquality' });
  $('.fcost').raty({ scoreName: 'rcost' });
  $('.famity').raty({ scoreName: 'ramity' });
});
</script>
     
     <p>{PHP.cfg.plugin.reviewstar.type_a}
        <div class="fquality"></div>
     </p>
     <p>{PHP.cfg.plugin.reviewstar.type_b}
        <div class="fcost"></div>
     </p>
     <p>{PHP.cfg.plugin.reviewstar.type_c}
        <div class="famity"></div>
     </p>
<!-- END: ADD -->

<!-- BEGIN: EDIT -->
<script>
$(document).ready(function() {
  $('.fquality').raty({ scoreName: 'rquality' }).raty('score', {STAR_1});
  $('.fcost').raty({ scoreName: 'rcost' }).raty('score', {STAR_2});
  $('.famity').raty({ scoreName: 'ramity' }).raty('score', {STAR_3});
});
</script>
     
     <p>{PHP.cfg.plugin.reviewstar.type_a}
        <div class="fquality"></div>
     </p>
     <p>{PHP.cfg.plugin.reviewstar.type_b}
        <div class="fcost"></div>
     </p>
     <p>{PHP.cfg.plugin.reviewstar.type_c}
        <div class="famity"></div>
     </p>
<!-- END: EDIT -->

<!-- BEGIN: SHOW -->

					<p class="pull-left margin10 textcenter">{PHP.cfg.plugin.reviewstar.type_a} <br />
          <span class="reviewstar" data-number="{STAR_1}"></span></p>
          
          <p class="pull-left margin10 textcenter">{PHP.cfg.plugin.reviewstar.type_b} <br />
          <span class="reviewstar" data-number="{STAR_2}"></span></p>
					
          <p class="pull-left margin10 textcenter">{PHP.cfg.plugin.reviewstar.type_c} <br />
          <span class="reviewstar" data-number="{STAR_3}"></span></p>
          
          <div class="clearfix"></div>
<!-- END: SHOW -->
       
<!-- END: MAIN -->