<!-- BEGIN: MAIN -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={PHP.cfg.plugin.prjmap.apikey}"></script>
    <script>
var geocoder;
var map;      
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  
  var mapOptions = {
    zoom: {PHP.cfg.plugin.prjmap.zoom},
    center: latlng,
    disableDefaultUI: <!-- IF {PHP.cfg.plugin.prjmap.disableui} -->true<!-- ELSE -->false<!-- ENDIF -->,
    scrollwheel: <!-- IF {PHP.cfg.plugin.prjmap.mapscroll} -->false<!-- ELSE -->true<!-- ENDIF -->,
    mapTypeId: google.maps.MapTypeId.<!-- IF {PHP.cfg.plugin.prjmap.type} == 1 -->ROADMAP<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 2 -->SATELLITE<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 3 -->HYBRID<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 4 -->TERRAIN<!-- ENDIF -->
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}
 
function codeAddress() {
  geocoder.geocode( { 'address': '{PRJ_CITY}, {PRJ_ADR}'}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);      
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
      });
      <!-- IF {PHP.cfg.plugin.prjmap.icon} -->marker.setIcon('{PHP.cfg.plugin.prjmap.icon}');<!-- ENDIF -->
    }
  });
};  
google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, 'load', codeAddress);
</script>
<div id="map-canvas"></div>
<!-- END: MAIN -->