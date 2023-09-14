<!-- BEGIN: MAIN -->
		<div class="block">
			<h2 class="users">
        <a href="{PHP|cot_url('plug','e=savesearch')}">
          История поиска
          <!-- IF {PHP.uid} > 0 OR {PHP.uip} -->
           пользователя с <b><!-- IF {PHP.uid} > 0 -->id {PHP.uid}<!-- ELSE -->ip {PHP.uip}<!-- ENDIF --></b>
          <!-- ELSE -->
          пользователей
          <!-- ENDIF -->
        </a>
        <small class="pull-right">
          <a class="btn btn-danger" href="{PHP|cot_url('plug','e=savesearch&a=reset')}">Очистить историю</a>
        </small>
      </h2>
      <form id="savesearch_form" action="/" method="GET">
        <input type="hidden" name="e" value="savesearch" />
        <input type="hidden" name="uid" value="{PHP.uid}" />
        <input type="hidden" name="uip" value="{PHP.uip}" />
        <div class="row">
          <div class="span2">
            Фраза
            <br>
            {PHP.sq|cot_savesearch_input('all', $this, 'sq', 'style="width: 100%"')}
          </div>
          <div class="span2">
            Дата начала:
            <br>
            <input type="text" name="datestart" value="{PHP.datestart|cot_date('d.m.Y H:i', $this)}" placeholder="В формате {PHP.sys.now|cot_date('d.m.Y H:i', $this)}" style="width: 100%;" />
          </div>
          <div class="span2">
            Дата конца:
            <br>
            <input type="text" name="dateend" value="{PHP.dateend|cot_date('d.m.Y H:i', $this)}" placeholder="В формате {PHP.sys.now|cot_date('d.m.Y H:i', $this)}" style="width: 100%;" />
          </div>
          <div class="span2">
            <br>
            <button type="submit" class="btn btn-default">Поиск</button>
          </div>
          <div class="span2">
            <br>
            Авто-обновление <b><!-- IF {PHP.ajaxupdate} -->Вкл<!-- ELSE -->Выкл<!-- ENDIF --></b>
          </div>
        </div>
      </form>
			<table class="table cells">
				<thead>
					<tr>
            <th>Время</th>
            <th>Пользователь</th>
						<th>Параметры</th>
            <th>Подробнее</th>
					</tr>
				</thead>
				<tbody class="savesearch_table">
					<!-- BEGIN: SS_ROW -->
					<tr data-uid="{SS_U_ID}" data-uip="{SS_U_IP}" class="parsed">
            <td>{SS_DATE}</td>
          	<td>{SS_U_NAME} {SS_U_IP}</td>
						<td>{SS_TITLE} <a href="{SS_URL}" target="_blank">Открыть</a></td>
            <td><a href="{SS_U_MORE}">подробнее..</a></td>
					</tr>
					<!-- END: SS_ROW -->
				</tbody>
			</table>
		</div>
    <!-- IF {PHP.ajaxupdate} -->
    <script>
      var savesearch_lasttime = {PHP.sys.now};
      function savesearch_update() {
        var savesearch_table = $('.savesearch_table').eq(0);
        $.getJSON('index.php?' + $('#savesearch_form').serialize().replace('e=savesearch', 'r=savesearch&a=load') + '&lasttime=' + savesearch_lasttime, function(data) {
          var newtr;
          savesearch_lasttime = data.date;
          data = data.list;

          for(i=0; data.length > i;i++) {
            if(data[i]['SS_U_ID'] > 0) {
              savesearch_table.find('tr[data-uid="'+data[i]['SS_U_ID']+'"]').remove();
            } else {
              savesearch_table.find('tr[data-uip="'+data[i]['SS_U_IP']+'"]').remove();
            }

            newtr = $('<tr data-uid="'+data[i]['SS_U_ID']+'" data-uip="'+data[i]['SS_U_IP']+'" class="not-parsed"></tr>');
            newtr.append('<td>'+data[i]['SS_DATE']+'</td>');
            newtr.append('<td>'+data[i]['SS_U_NAME']+' '+data[i]['SS_U_IP']+'</td>');
            newtr.append('<td>'+data[i]['SS_TITLE']+'  <a href="'+data[i]['SS_URL']+'" target="_blank">Открыть</a></td>');
            newtr.append('<td><a href="'+data[i]['SS_U_MORE']+'">подробнее..</a></td>');

            savesearch_table.prepend(newtr);
          }
          setTimeout(function() {
            savesearch_table.find('.not-parsed').removeClass('not-parsed').addClass('parsed');
          }, 500);
        });
        setTimeout(function() {
          savesearch_update();
        }, 5000);
      }
      $().ready(function() {
        setTimeout(function() {
          savesearch_update();
        }, 2000);
      });
    </script>
    <!-- ENDIF -->
    <style>
      .savesearch_table tr {
        transition: all 1s;
        background-color: yellow;
      }
      .savesearch_table tr.parsed {
        background-color: white;
      }
    </style>
<!-- END: MAIN -->