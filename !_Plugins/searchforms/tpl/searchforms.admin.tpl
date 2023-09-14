<!-- BEGIN: MAIN -->
<div class="container">
	<div class="row">
		<div class="span12">
      <h3>
       Добавление формы
      </h3>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
      <form method="POST" action="{PHP|cot_url('admin', 'm=other&p=searchforms&a=add')}">
       <div class="row">
         <div class="span3">
           Укажите уникальный код формы:
         </div>
         <div class="span2">
           <input type="text" name="rcode"/>
         </div>
         <div class="span7"></div>
       </div>
       <div class="row">
         <div class="span3">
           Выберите модули для поиска:
         </div>
         <div class="span9" data-sform="rmodules">
           {FORM_ADD_MODULES}
         </div>
       </div>
       <div class="row">
         <div class="span3">
         </div>
         <div class="span9">
          <div class="well well-small" data-sform="rsetup">
            <div data-sform="choisemodules">Выберите хотя бы один модуль для поиска</div>
            <div data-sform="setupmodules" style="display:none;">Настройте параметры поиска для выбранных модулей</div>
            <div data-sform="module_page" style="display:none;">
             <h2>Модуль Page</h2>
             <table class="cells">
      					<tr>
      						<th>Название поля:</th>
      						<th>Поиск по полю</th>
                  <th>Сортировка по полю</th>
      					</tr>
      					<tr>
      						<td>ID:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_ID}</td>
                  <td>{FORM_MOD_PAGE_SORT_ID}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Category}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_CAT}</td>
                  <td>{FORM_MOD_PAGE_SORT_CAT}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Title}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_TITLE}</td>
                  <td>{FORM_MOD_PAGE_SORT_TITLE}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Description}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_DESC}</td>
                  <td>{FORM_MOD_PAGE_SORT_DESC}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Text}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_TEXT}</td>
                  <td>{FORM_MOD_PAGE_SORT_TEXT}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.page_metakeywords}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_KEYWORDS}</td>
                  <td>{FORM_MOD_PAGE_SORT_KEYWORDS}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.page_metatitle}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_METATITLE}</td>
                  <td>{FORM_MOD_PAGE_SORT_METATITLE}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.page_metadesc}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_METADESC}</td>
                  <td>{FORM_MOD_PAGE_SORT_METADESC}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Author}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_AUTHOR}</td>
                  <td>{FORM_MOD_PAGE_SORT_AUTHOR}</td>
      					</tr>
                <!-- BEGIN: PAGEEXTRA -->
      					<tr>
      						<td>{FORM_MOD_PAGE_SEARCH_EXTRAFLD_TITLE}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_EXTRAFLD}</td>
                  <td>{FORM_MOD_PAGE_SORT_EXTRAFLD}</td>
      					</tr>
                <!-- END: PAGEEXTRA -->
       					<tr>
      						<td>{PHP.L.Hits}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_HITS}</td>
                  <td>{FORM_MOD_PAGE_SORT_HITS}</td>
      					</tr>
      					<tr>
      						<td>{PHP.L.Date}:</td>
      						<td>{FORM_MOD_PAGE_SEARCH_DATE}</td>
                  <td>{FORM_MOD_PAGE_SORT_DATE}</td>
      					</tr>
      				</table>
            </div>
            <div data-sform="module_market" style="display:none;">
             <h2>Модуль Market</h2>
             <table class="cells">
      					<tr>
      						<th>Название поля:</th>
      						<th>Поиск по полю</th>
                  <th>Сортировка по полю</th>
      					</tr>
                <tr>
          				<td>ID:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_ID}</td>
                  <td>{FORM_MOD_MARKET_SORT_ID}</td>
          			</tr>
                <tr>
          				<td>{PHP.L.Category}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_CAT}</td>
                  <td>{FORM_MOD_MARKET_SORT_CAT}</td>
          			</tr>
          			<tr>
          				<td>{PHP.L.Title}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_TITLE}</td>
                  <td>{FORM_MOD_MARKET_SORT_TITLE}</td>
          			</tr>
          			<tr>
          				<td>{PHP.L.Text}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_TEXT}</td>
                  <td>{FORM_MOD_MARKET_SORT_TEXT}</td>
          			</tr>
          			<tr>
          				<td>{PHP.L.projects_price}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_COST}</td>
                  <td>{FORM_MOD_MARKET_SORT_COST}</td>
          			</tr>
                <!-- BEGIN: MARKETEXTRA -->
      					<tr>
      						<td>{FORM_MOD_MARKET_SEARCH_EXTRAFLD_TITLE}:</td>
      						<td>{FORM_MOD_MARKET_SEARCH_EXTRAFLD}</td>
                  <td>{FORM_MOD_MARKET_SORT_EXTRAFLD}</td>
      					</tr>
                <!-- END: MARKETEXTRA -->
          			<tr>
          				<td>{PHP.L.Date}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_DATE}</td>
                  <td>{FORM_MOD_MARKET_SORT_DATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Update}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_UPDATE}</td>
                  <td>{FORM_MOD_MARKET_SORT_UPDATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Hits}:</td>
          				<td>{FORM_MOD_MARKET_SEARCH_HITS}</td>
                  <td>{FORM_MOD_MARKET_SORT_HITS}</td>
          			</tr>
      				</table>
            </div>
            <div data-sform="module_projects" style="display:none;">
             <h2>Модуль Projects</h2>
             <table class="cells">
      					<tr>
      						<th>Название поля:</th>
      						<th>Поиск по полю</th>
                  <th>Сортировка по полю</th>
      					</tr>
                <tr>
          				<td>ID:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_ID}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_ID}</td>
          			</tr>
                <tr>
          				<td>{PHP.L.Category}:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_CAT}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_CAT}</td>
          			</tr>
          			<tr>
          				<td>{PHP.L.Title}:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_TITLE}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_TITLE}</td>
          			</tr>
          			<tr>
          				<td>Описание:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_TEXT}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_TEXT}</td>
          			</tr>
          			<tr>
          				<td>Цена:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_COST}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_COST}</td>
          			</tr>
                <!-- BEGIN: PROJECTSEXTRA -->
      					<tr>
      						<td>{FORM_MOD_PROJECTS_SEARCH_EXTRAFLD_TITLE}:</td>
      						<td>{FORM_MOD_PROJECTS_SEARCH_EXTRAFLD}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_EXTRAFLD}</td>
      					</tr>
                <!-- END: PROJECTSEXTRA -->
          			<tr>
          				<td>{PHP.L.Date}:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_DATE}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_DATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Update}:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_UPDATE}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_UPDATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Hits}:</td>
          				<td>{FORM_MOD_PROJECTS_SEARCH_HITS}</td>
                  <td>{FORM_MOD_PROJECTS_SORT_HITS}</td>
          			</tr>
      				</table>
            </div>
            <div data-sform="module_demands" style="display:none;">
             <h2>Модуль Demands</h2>
             <table class="cells">
      					<tr>
      						<th>Название поля:</th>
      						<th>Поиск по полю</th>
                  <th>Сортировка по полю</th>
      					</tr>
                <tr>
          				<td>ID:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_ID}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_ID}</td>
          			</tr>
                <tr>
          				<td>{PHP.L.Category}:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_CAT}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_CAT}</td>
          			</tr>
          			<tr>
          				<td>{PHP.L.Title}:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_TITLE}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_TITLE}</td>
          			</tr>
          			<tr>
          				<td>Описание:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_TEXT}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_TEXT}</td>
          			</tr>
          			<tr>
          				<td>Цена:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_COST}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_COST}</td>
          			</tr>
                <!-- BEGIN: DEMANDSEXTRA -->
      					<tr>
      						<td>{FORM_MOD_DEMANDS_SEARCH_EXTRAFLD_TITLE}:</td>
      						<td>{FORM_MOD_DEMANDS_SEARCH_EXTRAFLD}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_EXTRAFLD}</td>
      					</tr>
                <!-- END: DEMANDSEXTRA -->
          			<tr>
          				<td>{PHP.L.Date}:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_DATE}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_DATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Update}:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_UPDATE}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_UPDATE}</td>
          			</tr>
        			  <tr>
          				<td>{PHP.L.Hits}:</td>
          				<td>{FORM_MOD_DEMANDS_SEARCH_HITS}</td>
                  <td>{FORM_MOD_DEMANDS_SORT_HITS}</td>
          			</tr>
      				</table>
            </div>
          </div>
         </div>
       </div>
       <div class="row">
         <div class="span3"></div>
         <div class="span2">
           <input type="submit" value="Добавить" class="btn">
         </div>
         <div class="span9"></div>
       </div>
      </form>

      <script>
       $('[data-sform="rmodules"] input[type="checkbox"]').change(function() {
         if($('[data-sform="rmodules"] input[type="checkbox"]:checked').length == 0) { $('[data-sform="choisemodules"]').show(); $('[data-sform="setupmodules"]').hide(); } else { $('[data-sform="choisemodules"]').hide(); $('[data-sform="setupmodules"]').show(); }
         console.log($(this).val());
         if($(this).prop('checked')) {
           $('[data-sform="module_'+$(this).val()+'"]').show();
         } else {
           $('[data-sform="module_'+$(this).val()+'"]').hide();
         }
       });

       $('[data-sform="rsetup"]').find('td').filter(':empty').html('Не доступно');
      </script>

    </div>
	</div>
	<div class="row">
		<div class="span3"><b>Код формы / тег</b></div>
		<div class="span7"><b>Доступные теги</b></div>
		<div class="span1"><b>Действие</b></div>
    <hr>
	</div>
	<!-- BEGIN: FORM_ROW -->
	<div class="row">
		<div class="span3">
     <b>{FORM_ROW_CODE}</b>
     <br>
     {FORM_ROW_TAG}
     <br>
     Шаблон <b>searchforms.form.{FORM_ROW_CODE}.tpl</b>
    </div>
		<div class="span7">
      <table class="cells">
    	 <!-- BEGIN: FORM_TAGS -->
        <tr>
          <td>{AREA}</td>
          <td>{TYPE}</td>
          <td><b>{NAME}</b></td>
          <td>{TAG}</td>
        </tr>
    	 <!-- END: FORM_TAGS -->
      </table>
    </div>
		<div class="span1"><a href="{FORM_ROW_DEL_URL}">Удалить</a></div>
	</div>
	<hr>
	<!-- END: FORM_ROW -->
</div>
<!-- END: MAIN -->