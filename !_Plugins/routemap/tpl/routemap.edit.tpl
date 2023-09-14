<!-- BEGIN: MAIN -->
{MAIN_SCRIPT}
<style>#map-canvas { width:100%;height:300px }</style>


<div id="for_error">
</div>
<input name="waypoints" value="{ROUTE_DATA}" type="hidden">
 <div class="input-append">
  <a role="button" data-routemap="placemarkonmap" title="Указать на карте"><i class="uk-icon-map-marker"></i></a>
  <input name="routefrom" value="{ROUTE_FROM_NAME}" type="text">
   <span class="add-on">Откуда</span>
 </div>
 
<div id="route_add">
<!-- BEGIN: ROUTE -->
<div class="input-append">
  <a role="button" data-routemap="placemarkonmap" title="Указать на карте"><i class="uk-icon-map-marker"></i></a>
  <input name="points" value="{ROUTE_POINT_NAME}" type="text">
  <span class="add-on">Через</span>
</div>
<!-- END: ROUTE -->
</div>

<div class="input-append">
  <a role="button" data-routemap="placemarkonmap" title="Указать на карте"><i class="uk-icon-map-marker"></i></a>
  <input name="routeto" value="{ROUTE_TO_NAME}" type="text">
  <span class="add-on">Куда</span>
</div>
<button class="btn btn-info" onclick="event.preventDefault(); addRoutePoint(); return false;">Добавить точку</button>
<button class="btn btn-success" id="btn-load" data-loading-text="Загрузка маршрута" onclick="event.preventDefault(); findRoute(); return false;">Проложить маршрут</button>

<hr />
<div id="map-canvas" style="display:none;"></div>
<!-- END: MAIN -->