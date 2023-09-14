<!-- BEGIN: MAIN -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={PHP.cfg.plugin.prjmap.apikey}"></script>

<script>
var geocoder;
var map;      
var marker;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(56.296729, 43.942565);
  
  var mapOptions = {
    zoom: 11,
    center: latlng,
    disableDefaultUI: <!-- IF {PHP.cfg.plugin.prjmap.disableui} -->true<!-- ELSE -->false<!-- ENDIF -->,
    scrollwheel: true,
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  marker = new google.maps.Marker({map: map, position:latlng, draggable: true});
  <!-- IF {PHP.cfg.plugin.prjmap.icon} -->marker.setIcon('{PHP.cfg.plugin.prjmap.icon}');<!-- ENDIF -->
  
  if($(document).find('form:not([id="GeoForm"])').find('#locselectcity').val() != 0)
  {
    $('#prjmap_adrpre').html($(document).find('form:not([id="GeoForm"])').find('#locselectcity option:selected').text());
    geocogeAdr($(document).find('form:not([id="GeoForm"])').find('#locselectcity option:selected').text(), '{ADR}');
  }
  
  google.maps.event.addDomListener(map, 'click', function(e) { 
    marker.setPosition(e.latLng);
    adrGeocoge(e.latLng);
  });
  
  function handleEvent(e) {
    adrGeocoge(e.latLng);
  }

  marker.addListener('dragend', handleEvent);
    
 function adrGeocoge(LatLng)
 {
  var latlngStr = "+"+LatLng;
  latlngStr = latlngStr.replace("+(", "").replace(")", "").split(',', 2);
  var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
  geocoder.geocode({'location': latlng}, function(results, status) {  
    if (status === google.maps.GeocoderStatus.OK) {
       var adress = '';
       if(results[0].address_components[0].types[0] == 'street_number')
       {
         adress = results[0].address_components[1].short_name+" "+results[0].address_components[0].short_name;
       }
       else
       {
         adress = results[0].address_components[0].short_name;
       }
       
       $('[name="ritem_adr"]').val(adress+'#'+latlngStr[0]+','+latlngStr[1]).change();
       $('#prjmap_adrinput').val(adress);
     }
  });
 }
 
 function geocogeAdr(city, adr)
 {
  geocoder.geocode( {'address': city+" "+adr}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);      
      marker.setPosition(results[0].geometry.location);
      if(adr)
      {
       var val = adr+'#'+results[0].geometry.location;
       val = val.replace("(", "").replace(")", "");
       $('[name="ritem_adr"]').val(val).change();
      }
    }
  });
 }
 
 $('#prjmap_adrinput').keydown(function(e) {
  var prj_adr = $(this).val();
  if(e.keyCode==13)
  { 
    e.preventDefault(); 
    if($('#prjmap_adrpre').html() != 'Выберите город')
    {
      geocogeAdr($('#prjmap_adrpre').html(), prj_adr);
    }
  }
 });  

 $('#prjmap_adrinput').change(function(e) {
  var prj_adr = $(this).val();
    if($('#prjmap_adrpre').html() != 'Выберите город')
    {
      geocogeAdr($('#prjmap_adrpre').html(), prj_adr);
    }
 });  

 $(document).find('form:not([id="GeoForm"])').find('#locselectcity').live("change", function(){
    if ($(this).val() != 0) {
      $('#prjmap_adrpre').html($(document).find('form:not([id="GeoForm"])').find('#locselectcity option[value="'+$(this).val()+'"]').filter(':first').text());
      geocogeAdr($('#prjmap_adrpre').html(), $('#prjmap_adrinput').val());
    }
 });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
<!-- END: MAIN -->