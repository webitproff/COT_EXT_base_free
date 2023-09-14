<!-- BEGIN: MAIN -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={PHP.cfg.plugin.routemap.apikey}"></script>
    <script>
var map;
var directionsDisplay;
var directionsService;
var inityes = true;
var markers = [];

function initialize_route() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(50.07276,43.23357);
  var mapOptions = {
    zoom: 12,
    center: latlng,
    scrollwheel: <!-- IF {PHP.cfg.plugin.routemap.rmscroll} -->false<!-- ELSE -->true<!-- ENDIF -->
  };
  map = new google.maps.Map(document.getElementById('map-canvas-route'), mapOptions);

			directionsDisplay = new google.maps.DirectionsRenderer();
			directionsService = new google.maps.DirectionsService();
			directionsDisplay.setMap(map);
}


function createRoute() {
  var waypts = [];

  $.ajaxSetup({
      async: false
  });

  $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address={ROUTE_FROM_NAME}&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
              var p = data.results[0].geometry.location;
              var start_point = new google.maps.LatLng(p.lat, p.lng);

              step_1(start_point);
  });

  function step_1(start_point) {
      $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address={ROUTE_TO_NAME}&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
              var p = data.results[0].geometry.location;
              var end_point = new google.maps.LatLng(p.lat, p.lng);

              step_2(start_point, end_point);
      });
  }

  function step_2(start_point, end_point) {
    <!-- BEGIN: ROUTE -->
          $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address={ROUTE_POINT_NAME}&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
              var p = data.results[0].geometry.location;
              var wayLatLng = new google.maps.LatLng(p.lat, p.lng);
              waypts.push({
                location: wayLatLng,
                stopover: true
              });
          });
    <!-- END: ROUTE -->

    step_3(start_point, end_point, waypts);
  }

  function step_3(start_point, end_point, waypts) {
  			var request = {
  			 origin: start_point,
  			 destination: end_point,
         waypoints: waypts,
         optimizeWaypoints: true,
  			 travelMode: google.maps.TravelMode.DRIVING,
  			 unitSystem: google.maps.UnitSystem.METRIC
  			};

  	directionsService.route(request, function(response, status) {
  		if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
  		}
  	});
   }

  $.ajaxSetup({
      async: true
  });
}

google.maps.event.addDomListener(window, 'load', initialize_route);
google.maps.event.addDomListener(window, 'load', createRoute);
</script>
<style>#map-canvas-route { width:100%;height:300px;margin-top: 10px; }</style>
<div id="map-canvas-route"></div>
<!-- END: MAIN -->