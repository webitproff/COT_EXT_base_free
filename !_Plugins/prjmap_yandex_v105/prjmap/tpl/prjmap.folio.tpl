<!-- BEGIN: MAIN -->
<script src="https://api-maps.yandex.ru/2.1/?apikey={PHP.cfg.plugin.prjmap.apikey}&lang=ru_RU" type="text/javascript"></script>

<script>
ymaps.ready(function() {
  var yandexmap, placemark;
  var ya_lat = -34.397, ya_lng = 150.644, ya_bound;

  yandexmap = new ymaps.Map("map-canvas-{PRJMAP_ID}", {
    center: [ya_lat, ya_lng],
    zoom: 12,
    controls: []
  });

  placemark = new ymaps.Placemark([ya_lat, ya_lng], {
    hintContent: '{PRJ_CITY}, {PRJ_ADR}'
  });
  yandexmap.geoObjects.add(placemark);

  <!-- IF {PRJMAP_LAT} AND {PRJMAP_LNG} -->
    ya_lat = {PRJMAP_LAT};
    ya_lng = {PRJMAP_LNG};

    placemark.geometry.setCoordinates([ya_lat, ya_lng]);
    yandexmap.setCenter([ya_lat, ya_lng]);
  <!-- ELSE -->
    ymaps.geocode('{PRJ_CITY}, {PRJ_ADR}', {
      results: 1
    }).then(function (res) {
        var firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates(),
            bounds = firstGeoObject.properties.get('boundedBy');

      ya_bound = bounds;
      ya_lat = coords[0];
      ya_lng = coords[1];

      placemark.geometry.setCoordinates(coords);
      yandexmap.setCenter(coords);
    });
  <!-- ENDIF -->
});
</script>

<div id="map-canvas-{PRJMAP_ID}"></div>
<style>#map-canvas-{PRJMAP_ID} { width:100%;height:300px }</style>
<!-- END: MAIN -->
