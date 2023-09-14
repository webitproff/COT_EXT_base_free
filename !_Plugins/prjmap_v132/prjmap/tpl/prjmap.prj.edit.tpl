<!-- BEGIN: MAIN -->
  <div class="clearfix"></div>
    <hr />
  <div class="input-group">
    <span id="prjmap_adrpre" class="input-group-addon"><!-- IF {PHP.item.item_city} > 0 -->{PHP.item.item_city|cot_getcity($this)}<!-- ELSE -->Выберите город<!-- ENDIF --></span>
    <input id="prjmap_adrinput" value="{ADR}" type="text" class="form-control" placeholder="Введите адрес или перетащите метку">
  </div>  

  <input name="ritem_adr" value="{INPUT_VAL}" type="hidden">
    <br>
  <div id="map-canvas"></div>
  
{MAIN_SCRIPT}
<style>#map-canvas { width:100%;height:300px }</style>
<!-- END: MAIN -->