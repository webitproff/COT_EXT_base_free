<!-- BEGIN: MAIN -->
<script src="https://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU<!-- IF {PHP.cfg.plugin.routemap.apikey_ynd} -->&apikey={PHP.cfg.plugin.routemap.apikey_ynd}<!-- ENDIF -->" type="text/javascript"></script>
<script>
  var map;
  var markers = [];
  var rmpl_active = null;
  function initialize() {
    map = new ymaps.Map(document.getElementById('map-canvas'), {
      center: [50.07276,43.23357],
      zoom: 12,
      scrollwheel: <!-- IF {PHP.cfg.plugin.routemap.rmscroll} -->false<!-- ELSE -->true<!-- ENDIF -->
    }, {
      searchControlProvider: 'yandex#search'
    });

    $('[name="routefrom"], [name="points"], [name="routeto"]').each(function() {
      var ym_suggest = 'ym_suggest'+parseInt(Math.random()*10000000);
      $(this).attr('id', ym_suggest);
      var ym_suggest = new ymaps.SuggestView(ym_suggest);
    });

    map.events.add('click', function (e) {
      var coords = e.get('coords');

      if(rmpl_active !== null && rmpl_active.length > 0 && coords.length == 2)
        {
          var olm_p_Placemark = new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
          }, {
            preset: 'islands#orangeDotIcon',
            draggable: false
          });

          map.geoObjects.add(olm_p_Placemark);

          ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            var cord_name =
                [ firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                  firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                ].filter(Boolean).join(', ');

            olm_p_Placemark.properties.set({ iconCaption: cord_name });

            var thisinp = rmpl_active.parent().find('input');

            thisinp.val(cord_name);
            thisinp.attr('placeholder', '');
            thisinp.attr('data-rmplval', '');

            rmpl_active.removeClass('active');
            rmpl_active = null;

            if($('input[name="routefrom"]').val() != '' && $('input[name="routeto"]').val() != '') findRoute();
          });
        }
    });

    if($('input[name="routefrom"]').val() != '' && $('input[name="routeto"]').val() != '') findRoute();
  }

  function findRoute() {
    map.geoObjects.removeAll();

    var save_res = [];
    var waypts = [];
    var save_input = document.getElementsByName('waypoints')[0]
    var r_from = document.getElementsByName('routefrom')[0];
    var r_to = document.getElementsByName('routeto')[0];

    $('#for_error').hide();

    if (r_to.value === '' || r_from.value === '') {
       $('#for_error').show().html('<div class="alert">Ошибка! Укажите точки маршрута</div>');
       return false;
    }

    waypts.push(r_from.value);

    var allpoints = document.getElementsByName('points');

    for (var i = 0; i < allpoints.length; i++) {
      if (allpoints[i].value != '') {
        waypts.push({
           point: allpoints[i].value,
           type: 'viaPoint'
        });
      }
    }

    waypts.push(r_to.value);

    ymaps.route(waypts).then(function (route) {
      map.geoObjects.add(route);

      var points = route.getWayPoints(),
          points_length = points.getLength();

      if(points_length == 2) {
          points.options.set('preset', 'islands#redStretchyIcon');
          points.get(0).properties.set('iconContent', 'Точка отправления');
          points.get(1).properties.set('iconContent', 'Точка прибытия');

          save_res.push(r_from.value+'#'+points.get(0).geometry.getCoordinates());

          var viaPoints = route.getViaPoints(),
              viaPoints_length = viaPoints.getLength();

          for (var i = 0; i < allpoints.length; i++) {
            if (viaPoints_length >= i && allpoints[i].value != '') {
              save_res.push(allpoints[i].value+'#'+viaPoints.get(i).geometry.getCoordinates());
            }
          }

          save_res.push(r_to.value+'#'+points.get(1).geometry.getCoordinates());
      } else {
        $('#for_error').show().html('Возникла ошибка: ' + error.message);
      }

      $('input[name="waypoints"]').val(save_res.join('&'));
    }, function (error) {
       $('#for_error').show().html('Возникла ошибка: ' + error.message);
    });
  }

  function addRoutePoint() {
    $('#route_add').append('<div><a role="button" data-routemap="placemarkonmap" class="placemarkonmap_notinit" title="Указать на карте"><i class="uk-icon-map-marker"></i></a> <input name="points" value="" type="text"> Через</div>');

    var ym_suggest = 'ym_suggest'+parseInt(Math.random()*10000000);
    $('#route_add').find('a.placemarkonmap_notinit').attr('id', ym_suggest);
    var ym_suggest = new ymaps.SuggestView(ym_suggest);
  }

  $(document).on('click', '[data-routemap="placemarkonmap"]', function() {
    var thispl = $(this),
        thisinp = thispl.parent().find('input');

    if(thispl.hasClass('active')) {
      thispl.removeClass('active');

      thisinp.val(thisinp.attr('data-rmplval'));
      thisinp.attr('placeholder', '');
      thisinp.attr('data-rmplval', '');

      rmpl_active = null;
    } else {
      $('[data-routemap="placemarkonmap"].active').each(function() {
        $(this).removeClass('active');
        var thisinp_tmp = $(this).parent().find('input');

        thisinp_tmp.val(thisinp_tmp.attr('data-rmplval'));
        thisinp_tmp.attr('placeholder', '');
        thisinp_tmp.attr('data-rmplval', '');
      });

      thispl.addClass('active');

      thisinp.attr('placeholder', 'Укажите точку на карте');
      thisinp.attr('data-rmplval', thisinp.val());
      thisinp.val('');

      if($('input[name="routefrom"]').val() != '' && $('input[name="routeto"]').val() != '') map.geoObjects.removeAll();

      rmpl_active = thispl;
    }
  });

  ymaps.ready(function(){
    initialize();
  });
</script>
<!-- END: MAIN -->