<!-- BEGIN: MAIN -->
<script src="https://api-maps.yandex.ru/2.1/?apikey={PHP.cfg.plugin.prjmap.apikey}&lang=ru_RU" type="text/javascript"></script>

<script>
var city_inp, prjmap_save, prjmap_search, prjmap_form = { length: 0 };
var yandexmap, placemark, suggestView;
var ya_lat = -34.397, ya_lng = 150.644, ya_bound;

function compliteAdr(latlng, street) {
  prjmap_search.val(street);
  prjmap_save.val(street + '#' + latlng.join(','));
  suggestView.state.set({open: false});
}

function compliteCity() {
  if(prjmap_form.length && prjmap_form.find('#locselectcity').length && prjmap_form.find('#locselectcity').val() != 0)
  {
    return prjmap_form.find('#locselectcity option:selected').text();
  }
  return '';
}

function compliteGeo(street) {
  var city = compliteCity();
  return (city != '' ? city + ', ' : '') + street;
}

function geocogeAdr(geo) {
  ymaps.geocode(geo, {
    results: 1
  }).then(function (res) {
      var firstGeoObject = res.geoObjects.get(0),
          coords = firstGeoObject.geometry.getCoordinates(),
          bounds = firstGeoObject.properties.get('boundedBy');

    ya_bound = bounds;
    suggestView.options.set('boundedBy', ya_bound);
    placemark.geometry.setCoordinates(coords);
    yandexmap.setCenter(coords);

    compliteAdr(coords, firstGeoObject.properties.get('name'));
  });
}

ymaps.ready(function() {
  prjmap_search = $('#prjmap_search');
  prjmap_save = $('#prjmap_save');
  prjmap_form = prjmap_save.closest('form');

  var n_ya_lat = parseFloat(prjmap_save.attr('data-lat'));
  var n_ya_lng = parseFloat(prjmap_save.attr('data-lng'));
  if(n_ya_lat && n_ya_lng) {
    ya_lat = n_ya_lat;
    ya_lng = n_ya_lng;
  } else if(compliteCity() != '') {
    ymaps.geocode(compliteCity(), {
      results: 1
    }).then(function (res) {
        var firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates(),
            bounds = firstGeoObject.properties.get('boundedBy');

      ya_bound = bounds;
      ya_lat = coords[0];
      ya_lng = coords[1];

      suggestView.options.set('boundedBy', ya_bound);
      placemark.geometry.setCoordinates(coords);
      yandexmap.setCenter(coords);
    });
  }

  suggestView = new ymaps.SuggestView('prjmap_search');
  suggestView.events.add('select', function(e) {
    geocogeAdr(e.get('item').value);
  });

  yandexmap = new ymaps.Map("map-canvas", {
    center: [ya_lat, ya_lng],
    zoom: 12,
    <!-- IF {PHP.cfg.plugin.prjmap.disableui} -->controls: [],<!-- ENDIF -->
  });

  placemark = new ymaps.Placemark([ya_lat, ya_lng]);
  yandexmap.geoObjects.add(placemark);

  yandexmap.events.add('click', function(e) {
    var coords = e.get('coords');
    geocogeAdr(coords);
  });

  prjmap_search.keydown(function(e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      geocogeAdr(compliteGeo($(this).val()));
    }
  });

  prjmap_search.change(function(e) {
    geocogeAdr(compliteGeo($(this).val()));
  });

  if(prjmap_form.length) prjmap_form.find('#locselectcity').on("change", function() {
    if ($(this).val() != 0) {
      compliteAdr([0, 0], '');
      geocogeAdr(compliteGeo(''));
    }
  });
});
</script>
<!-- END: MAIN -->
