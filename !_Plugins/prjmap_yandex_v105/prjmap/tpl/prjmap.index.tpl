<!-- BEGIN: MAIN -->
<!-- IF {ERROR} -->
<h1 class="text-center">Ошибка! Проверьте указанный город в настройках плагина, возможно он введен неправильно.</h1>
<!-- ELSE -->
<style>#map-canvas { width:100%; height:500px; } #map-canvas-leafletjs { width:100%; height:500px; }</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={PHP.cfg.plugin.prjmap.apikey}"></script><div id="map-canvas"></div>
<script>
var geocoder;
var map;
var centerfind;
var prevmark;
var previd;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(64.5071251,72.2487112);

  var mapOptions = {
    zoom: {PHP.cfg.plugin.prjmap.zoomindex},
    center: latlng,
    disableDefaultUI: <!-- IF {PHP.cfg.plugin.prjmap.disableui} -->true<!-- ELSE -->false<!-- ENDIF -->,
    scrollwheel: <!-- IF {PHP.cfg.plugin.prjmap.rmscroll} -->false<!-- ELSE -->true<!-- ENDIF -->,
    mapTypeId: google.maps.MapTypeId.<!-- IF {PHP.cfg.plugin.prjmap.type} == 1 -->ROADMAP<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 2 -->SATELLITE<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 3 -->HYBRID<!-- ENDIF -->
                                     <!-- IF {PHP.cfg.plugin.prjmap.type} == 4 -->TERRAIN<!-- ENDIF -->
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function codeAddress() {
  geocoder.geocode( { 'address': '<!-- IF {MAP_CENTER} -->{MAP_CENTER}<!-- ELSE -->{PHP.cfg.plugin.prjmap.center}<!-- ENDIF -->'}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      centerfind = 0;
      }
      else
      {
      centerfind = 1;
      }
  });

<!-- BEGIN: PRJMAP_ROWS -->
<!-- IF {PRJ_ROW_PRJMAP_ADR} -->
  geocoder.geocode( { 'address': '{PRJ_ROW_CITY}, {PRJ_ROW_PRJMAP_ADR}'}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (centerfind)
      {
      map.setCenter(results[0].geometry.location);
      }

      var infowindow{PRJ_ROW_ID} = new google.maps.InfoWindow({
      content: '{CONTENT}'
      });

      var marker{PRJ_ROW_ID} = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          title: '{PRJ_ROW_SHORTTITLE}'
      });
      <!-- IF {PHP.cfg.plugin.prjmap.rmicon} -->marker.setIcon('{PHP.cfg.plugin.prjmap.rmicon}');<!-- ENDIF -->

      google.maps.event.addListener(marker{PRJ_ROW_ID}, 'click', function() {
        if (prevmark)
        {
         prevmark.close();
        }
        prevmark = infowindow{PRJ_ROW_ID};
        infowindow{PRJ_ROW_ID}.open(map,marker{PRJ_ROW_ID});
        previd = {PRJ_ROW_ID};
      });
    }
  });
<!-- ENDIF -->
<!-- END: PRJMAP_ROWS -->
    previd=null;
    prevmark=null;

    google.maps.event.addListener(map, 'click', function() {
     if (prevmark)
     {
      prevmark.close();
     }
    });
};
google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, 'load', codeAddress);
</script>
<!-- ENDIF -->
<!-- END: MAIN -->