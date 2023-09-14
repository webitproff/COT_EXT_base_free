<!-- BEGIN: MAIN -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={PHP.cfg.plugin.routemap.apikey}"></script>
    <script>
var map;      
var directionsDisplay;
var directionsService;
var inityes = true;
var markers = [];

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(50.07276,43.23357);
  var mapOptions = {
    zoom: 12,
    center: latlng,
    scrollwheel: <!-- IF {PHP.cfg.plugin.routemap.rmscroll} -->false<!-- ELSE -->true<!-- ENDIF -->
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			directionsDisplay = new google.maps.DirectionsRenderer();
			directionsService = new google.maps.DirectionsService();      
			directionsDisplay.setMap(map);
}

function findRoute() {
var save_res = [];
var waypts = [];
var save_input = document.getElementsByName('waypoints')[0]
var r_from = document.getElementsByName('routefrom')[0];
var r_to = document.getElementsByName('routeto')[0];

$('#for_error').hide();
if (r_to.value === '' || r_from.value === '') {
   $('#for_error').show().html('<div class="alert">Ошибка! Укажите точки маршрута</div>');
   return false;    
}else {
   if (inityes)
   {
    $('#map-canvas').show();
    initialize();
    inityes = false;
   }
}
$('#btn-load').button('loading');

$.ajaxSetup({
    async: false
});

$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+r_from.value+'&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
            var p = data.results[0].geometry.location;
            var start_point = new google.maps.LatLng(p.lat, p.lng);

            save_res = r_from.value+'#'+start_point;
            step_1(start_point, save_res);
});
        
function step_1(start_point, save_res) {        
    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+r_to.value+'&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
            var p = data.results[0].geometry.location;
            var end_point = new google.maps.LatLng(p.lat, p.lng);

            var save_finish = '&'+r_to.value+'#'+end_point;
            step_2(start_point, end_point, save_res, save_finish);
    });		
}

function step_2(start_point, end_point, save_res, save_finish) {	
  var allpoints = document.getElementsByName('points');
  for (var i = 0; i < allpoints.length; i++) {
    if (allpoints[i].value != '') {     
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+allpoints[i].value+'&sensor=false&key={PHP.cfg.plugin.routemap.apikey}', null, function (data) {
            var p = data.results[0].geometry.location;
            var wayLatLng = new google.maps.LatLng(p.lat, p.lng);
            waypts.push({
            location: wayLatLng,
            stopover: true
            });
            save_res += '&'+allpoints[i].value+'#'+wayLatLng;
        });
    }  
  }
  save_res += save_finish;
  step_3(start_point, end_point, save_res, waypts);       
}

function step_3(start_point, end_point, save_res, waypts) {
      save_input.value = save_res;		
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
      $('#btn-load').button('reset');
		}
    else
    {
     $('#for_error').show().html('<div class="alert">Ошибка! Не удалось построить маршрут</div>');
     $('#btn-load').button('reset');
    }
	});
 }

$.ajaxSetup({
    async: true
});
}

function addRoutePoint() {
  $('#route_add').append('<div><input name="points" value="" type="text"> Через</div>');
}
 
</script>
<!-- END: MAIN -->