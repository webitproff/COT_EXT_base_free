<!-- BEGIN: MAIN -->
<script src="https://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU<!-- IF {PHP.cfg.plugin.routemap.apikey_ynd} -->&apikey={PHP.cfg.plugin.routemap.apikey_ynd}<!-- ENDIF -->" type="text/javascript"></script>
<script>
  var map_route;

  function initialize_route() {
    map = new ymaps.Map(document.getElementById('map-canvas-route'), {
      center: [50.07276,43.23357],
      zoom: 12,
      scrollwheel: <!-- IF {PHP.cfg.plugin.routemap.rmscroll} -->false<!-- ELSE -->true<!-- ENDIF -->
    }, {
      //searchControlProvider: 'yandex#search'
    });

    var waypts = [];

    waypts.push('{ROUTE_FROM_NAME}');
    <!-- BEGIN: ROUTE -->
      waypts.push('{ROUTE_ALL_NAME}');
    <!-- END: ROUTE -->
    waypts.push('{ROUTE_TO_NAME}');

    var RouteTrip = new ymaps.multiRouter.MultiRoute({
            referencePoints: waypts,
            params: {
              results: 1,
              reverseGeocoding: false,
              <!-- IF {ROUTE_VIA_POINTS_COUNT} > 0 --> viaIndexes: [{ROUTE_VIA_POINTS}],<!-- ENDIF -->
            }
        }, {
            routeStrokeColor: "000088",
            routeActiveStrokeColor: "4296EA",
            pinIconFillColor: "ff0000",
            wayPointFinishIconFillColor: "#4296EA",
            wayPointStartIconFillColor: "#FFCE00",
            activeRouteAutoSelection: true,
            boundsAutoApply: true,
        });

    map.geoObjects.add(RouteTrip);
  }

  ymaps.ready(function(){
    initialize_route();
  });
</script>
<style>#map-canvas-route { width:100%;height:300px;margin-top: 10px; }</style>
<div id="map-canvas-route"></div>
<!-- END: MAIN -->