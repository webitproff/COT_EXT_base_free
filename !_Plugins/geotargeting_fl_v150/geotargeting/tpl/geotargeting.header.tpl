<!-- BEGIN: MAIN -->

<!-- IF {GEOTARGETING_MODAL_BUTTON} -->
<li class="dropdown {GEOTARGETING_DROP_OPEN}">            
	<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-map-marker icon-white"></i> {GEOTARGETING_NAME_SELECT}<b class="caret"></b></a>
		<ul class="dropdown-menu" style="min-width: 250px;">
     	<li class="textcenter"><h4>{PHP.L.you_city} {GEOTARGETING_NAME_SELECT}?</h4></li>
      <li><a href="#" onclick="document.getElementById('GeoForm').submit(); return false;">{PHP.L.Yes}</a></li>
      <li><a href="#" data-toggle="modal" onClick="$('#GeoModal').modal(); return false;">{PHP.L.No}</a></li>
		</ul>
</li>
<!-- ELSE -->                
<li>
  <a href="#" data-toggle="modal" onClick="$('#GeoModal').modal(); return false;"><i class="icon-map-marker icon-white"></i> {GEOTARGETING_NAME_SELECT}</a> 
</li>
<!-- ENDIF -->

<!-- END: MAIN -->