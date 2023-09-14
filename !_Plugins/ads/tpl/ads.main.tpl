<!-- BEGIN: MAIN -->           
<div class="row">
 <div class="span12">    
  <!-- BEGIN: EDIT -->
    <h1>{PAGE_TITLE}</h1>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
      <form action="{ADS_FORM_ID|cot_url('plug', 'e=ads&a=edit&act=save&id='$this)}" method="POST" ENCTYPE="multipart/form-data" class="form-horizontal">
        <table class="table">
					<tbody>
          <tr>
						<td class="width30">{PHP.L.Title}:</td>
						<td class="width70">{ADS_FORM_TITLE}</td>
					</tr>
          <!-- IF {PHP.ads.item_expire} == 0 AND {PHP.ads.item_paused} == 0 -->
					<tr>
						<td>{PHP.L.ads_place}:</td>
						<td>{ADS_FORM_CATEGORY}</td>
					</tr>
					<tr>
						<td>{PHP.L.ads_expire_time}:</td>
						<td>{ADS_FORM_PERIOD}</td>
					</tr>
          <!-- ENDIF -->
					<tr>
						<td>{PHP.L.Image}:</td>
						<td>
              <img src="{ADS_FORM_IMAGE}" style="width:100%"/>
              {ADS_FORM_FILE}
            </td>
					</tr>
					<tr>
						<td>{PHP.L.ads_alt}:</td>
						<td>{ADS_FORM_ALT}</td>
					</tr>
					<tr>
						<td>{PHP.L.ads_click_url}:</td>
						<td>
              {ADS_FORM_CLICKURL}
              <small>В формате http://mysite.ru</small>
            </td>
					</tr>
					<tr>
						<td>{PHP.L.Description}:</td>
						<td>{ADS_FORM_DESCRIPTION}</td>
					</tr>   
          <!-- BEGIN: EXTRAFLD -->
					<tr>
						<td>{ADS_FORM_EXTRAFLD_TITLE}:</td>
						<td>{ADS_FORM_EXTRAFLD}</td>
					</tr>  
          <!-- END: EXTRAFLD -->      
					<tr>
						<td></td>
						<td><button class="btn btn-success">{PHP.L.Save}</button></td>
					</tr>
				</tbody>
      </table>
  <!-- END: EDIT -->
                        
  <!-- BEGIN: SHOW -->
    <h1>{PAGE_TITLE}
      <a href="{PHP|cot_url('plug', 'e=ads')}#create" data-toggle="tab" class="btn btn-success pull-right">Создать</a>
    </h1>
		 {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
      <div class="tab-content">  
       <div role="tabpanel" class="tab-pane fade" id="create">
        <form action="{PHP|cot_url('plug', 'e=ads&a=edit&act=add')}" method="POST" ENCTYPE="multipart/form-data" class="form-horizontal">
        <table class="table">
					<tbody>
					<tr>
						<td>{PHP.L.Title}:</td>
						<td>{ADS_FORM_TITLE}</td>
					</tr> 
					<tr>
						<td>{PHP.L.ads_place}:</td>
						<td>{ADS_FORM_CATEGORY}</td>
					</tr>
					<tr>
						<td>{PHP.L.ads_expire_time}:</td>
						<td>{ADS_FORM_PERIOD}</td>
					</tr> 
					<tr>
						<td>{PHP.L.Image}:</td>
						<td>{ADS_FORM_FILE}</td>
					</tr> 
					<tr>
						<td>{PHP.L.ads_alt}:</td>
						<td>{ADS_FORM_ALT}</td>
					</tr> 
					<tr>
						<td>{PHP.L.ads_click_url}:</td>
						<td>
               {ADS_FORM_CLICKURL}
               <small>В формате http://mysite.ru</small>
            </td>
					</tr>
					<tr>
						<td>{PHP.L.Description}:</td>
						<td>{ADS_FORM_DESCRIPTION}</td>
					</tr> 
          <!-- BEGIN: EXTRAFLD -->
					<tr>
						<td>{ADS_FORM_EXTRAFLD_TITLE}:</td>
						<td>{ADS_FORM_EXTRAFLD}</td>
					</tr>  
          <!-- END: EXTRAFLD -->      
					<tr>
						<td></td>
						<td><button class="btn btn-success">{PHP.L.ads_publish}</button></td>
					</tr>
				</tbody>
       </table>
	    </form>
     </div>
    </div>
   
   <hr>
              
    <!-- IF {ADS_COUNT} == 0 -->
      <p>Активных баннеров нет.</p>
    <!-- ENDIF -->
              
    <!-- BEGIN: ADS_ROW -->
      <div class="row"> 
        <div class="span12">
         <div class="well">
            <h4>{ADS_ROW_TITLE}
                <!-- IF {ADS_ROW_DEL_URL} -->
                 <a class="pull-right" href="{ADS_ROW_DEL_URL}">{PHP.L.Delete}</a>
                <!-- ENDIF -->
               <a href="{ADS_ROW_EDIT_URL}">{PHP.L.Edit}</a>
             </h4>

                <div class="span3">
                  <img src="{ADS_ROW_IMAGE}" style="max-width:100%" alt="{ADS_ROW_ALT}"/>
                </div>
                      
                       <div class="span5">
                          <h4>Место размещения</h4>
                          <p>{ADS_ROW_CATEGORY_TITLE}</p>

                          <h4>Описание</h4>
                          <p>{ADS_ROW_DESCRIPTION}</p>
                          
                          <h4>Alt текст</h4>
                          <p>{ADS_ROW_ALT}</p>
                                                    
                          <h4>Url для перехода</h4>
                          <p>{ADS_ROW_URL}</p>
                       </div>
                       
                       <div class="span3">
                          <h3>Статус:</h3>
                          <p>
                           Срок размещения {ADS_ROW_PERIOD} <br>
                           <!-- IF {ADS_ROW_EXPIRE} == 0 AND {ADS_ROW_PAUSED} == 0 -->
                            <a class="btn btn-warning btn-sm" href="{ADS_ROW_ID|cot_url('plug', 'e=ads&act=buy&id='$this)}">Оплатить размещение</a>
                           <!-- ELSE -->
                             <!-- IF {ADS_ROW_EXPIRE} > {PHP.sys.now} -->
                              Размещен до <b>{ADS_ROW_EXPIRE|cot_date('d.m.Y',$this)}</b>
                               <br>
                              <a href="{ADS_ROW_ID|cot_url('plug', 'e=ads&act=paused&id='$this)}">Приостановить показ</a>
                             <!-- ELSE -->
                               <!-- IF {ADS_ROW_EXPIRE} > 0 -->
                                Завершен <b>{ADS_ROW_EXPIRE|cot_date('d.m.Y',$this)}</b
                               <!-- ENDIF -->
                               <!-- IF {ADS_ROW_PAUSED} > 0 -->
                                Остановлен <b>(Остаток {ADS_ROW_PAUSED_TIME})</b>
                                 <br>
                                <a href="{ADS_ROW_ID|cot_url('plug', 'e=ads&act=unpaused&id='$this)}">Возобновить показ</a>
                               <!-- ENDIF -->                            
                             <!-- ENDIF -->
                           <!-- ENDIF -->
                          </p>
                           
                    <h3>Статистика:</h3>
                      <p>Показов: <b>{ADS_ROW_SHOWS}</b>
                         <br>
                         Кликов: <b>{ADS_ROW_CLICKS}</b>
                      </p>
                      
                    </div>   
              <div class="clear"></div>
            </div>  
          </div>
        </div>       
      <!-- END: ADS_ROW -->
                 
    <!-- END: SHOW -->
  </div>
</div>
<!-- END: MAIN -->