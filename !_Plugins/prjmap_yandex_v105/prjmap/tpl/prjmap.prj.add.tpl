<!-- BEGIN: MAIN -->
  <div class="input-group">
    <input id="prjmap_search" value="{ADR}" type="text" class="uk-width-1-1" placeholder="Введите адрес или перетащите метку">
  </div>

  <input id="prjmap_save" name="ritemprjmap" value="{INPUT_VAL}" data-lat="{PRJMAP_LAT}" data-lng="{PRJMAP_LNG}" type="hidden">
    <br>
  <div id="map-canvas"></div>

{MAIN_SCRIPT}
<style>#map-canvas { width:100%;height:300px }</style>
<!-- END: MAIN -->
