<!-- BEGIN: MAIN -->
<!-- IF {ERROR} -->
<h1 class="text-center">Ошибка! Проверьте указанный город в настройках плагина, возможно он введен неправильно.</h1>
<!-- ELSE -->
<script src="https://api-maps.yandex.ru/2.1/?apikey={PHP.cfg.plugin.prjmap.apikey}&lang=ru_RU" type="text/javascript"></script>

<style>#map-canvas { width:100%; height:700px; }</style>
<div id="map-canvas"></div>

<script>
ymaps.ready(function() {
  var yandexmap;
  var ya_lat = -34.397, ya_lng = 150.644, ya_bound;

  yandexmap = new ymaps.Map("map-canvas", {
    center: [ya_lat, ya_lng],
    zoom: 12,
    controls: []
  });

  ymaps.geocode('<!-- IF {MAP_CENTER} -->{MAP_CENTER}<!-- ELSE -->{PHP.cfg.plugin.prjmap.center}<!-- ENDIF -->', {
    results: 1
  }).then(function (res) {
      var firstGeoObject = res.geoObjects.get(0),
          coords = firstGeoObject.geometry.getCoordinates(),
          bounds = firstGeoObject.properties.get('boundedBy');

    ya_bound = bounds;
    ya_lat = coords[0];
    ya_lng = coords[1];

    yandexmap.setCenter(coords);
  });

  <!-- BEGIN: USERS_ROWS -->
    <!-- IF {USERS_ROW_PRJMAP_ADR} -->
    var placemark_{USERS_ROW_ID} = new ymaps.Placemark([ya_lat, ya_lng], {
      hintContent: '{USERS_ROW_NICKNAME}',
      balloonContent: '{CONTENT}'
    });
    yandexmap.geoObjects.add(placemark_{USERS_ROW_ID});

      <!-- IF {USERS_ROW_PRJMAP_LAT} AND {USERS_ROW_PRJMAP_LNG} -->
        ya_lat = {USERS_ROW_PRJMAP_LAT};
        ya_lng = {USERS_ROW_PRJMAP_LNG};

        placemark_{USERS_ROW_ID}.geometry.setCoordinates([ya_lat, ya_lng]);
        yandexmap.setCenter([ya_lat, ya_lng]);
      <!-- ELSE -->
        ymaps.geocode('{USERS_ROW_CITY}, {USERS_ROW_PRJMAP_ADR}', {
          results: 1
        }).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0),
                coords = firstGeoObject.geometry.getCoordinates(),
                bounds = firstGeoObject.properties.get('boundedBy');

          ya_bound = bounds;
          ya_lat = coords[0];
          ya_lng = coords[1];

          placemark_{USERS_ROW_ID}.geometry.setCoordinates(coords);
          yandexmap.setCenter(coords);
        });
      <!-- ENDIF -->
    <!-- ENDIF -->
  <!-- END: USERS_ROWS -->
});
</script>

<!-- ENDIF -->
<!-- END: MAIN -->
