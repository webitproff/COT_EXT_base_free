<!-- BEGIN: MAIN -->
		<div class="block">
			<h2 class="users">
        <a href="{PHP|cot_url('plug','e=whowhere')}">
          История просмотров
          <!-- IF {PHP.uid} > 0 OR {PHP.uip} -->
           пользователя с <b><!-- IF {PHP.uid} > 0 -->id {PHP.uid}<!-- ELSE -->ip {PHP.uip}<!-- ENDIF --></b>
          <!-- ELSE -->
          пользователей
          <!-- ENDIF -->
        </a>
        <small class="pull-right">
          <a class="btn btn-danger" href="{PHP|cot_url('plug','e=whowhere&a=reset')}">Очистить историю</a>
        </small>
      </h2>
      <form id="whowhere_form" action="/" method="GET">
        <input type="hidden" name="e" value="whowhere" />
        <input type="hidden" name="uid" value="{PHP.uid}" />
        <input type="hidden" name="uip" value="{PHP.uip}" />
        <div class="row">
          <div class="span2" style="text-align: right;padding-top: 5px;">
            Дата начала:
          </div>
          <div class="span2">
            <input type="text" name="datestart" value="{PHP.datestart|cot_date('d.m.Y H:i', $this)}" placeholder="В формате {PHP.sys.now|cot_date('d.m.Y H:i', $this)}" style="width: 100%;" />
          </div>
          <div class="span2" style="text-align: right;padding-top: 5px;">
            Дата конца:
          </div>
          <div class="span2">
            <input type="text" name="dateend" value="{PHP.dateend|cot_date('d.m.Y H:i', $this)}" placeholder="В формате {PHP.sys.now|cot_date('d.m.Y H:i', $this)}" style="width: 100%;" />
          </div>
          <div class="span2">
            <button type="submit" class="btn btn-default">Поиск</button>
          </div>
          <div class="span2">
            Авто-обновление <b><!-- IF {PHP.ajaxupdate} -->Вкл<!-- ELSE -->Выкл<!-- ENDIF --></b>
          </div>
        </div>
      </form>
			<table class="table cells">
				<thead>
					<tr>
            <th>Время</th>
            <th>Пользователь</th>
						<th>Просматривает</th>
            <th>Подробнее</th>
					</tr>
				</thead>
				<tbody class="whowhere_table">
					<!-- BEGIN: WW_ROW -->
					<tr data-uid="{WW_U_ID}" data-uip="{WW_U_IP}" class="parsed">
            <td>{WW_DATE}</td>
          	<td>{WW_U_NAME} {WW_U_IP}</td>
						<td>{WW_TITLE}</td>
            <td><a href="{WW_U_MORE}">подробнее..</a></td>
					</tr>
					<!-- END: WW_ROW -->
				</tbody>
			</table>
		</div>
    <!-- IF {PHP.ajaxupdate} -->
    <script>
      var whowhere_lasttime = {PHP.sys.now};
      function whowhere_update() {
        var whowhere_table = $('.whowhere_table').eq(0);
        $.getJSON('index.php?' + $('#whowhere_form').serialize().replace('e=whowhere', 'r=whowhere') + '&lasttime=' + whowhere_lasttime, function(data) {
          var newtr;
          whowhere_lasttime = data.date;
          data = data.list;

          for(i=0; data.length > i;i++) {
            if(data[i]['WW_U_ID'] > 0) {
              whowhere_table.find('tr[data-uid="'+data[i]['WW_U_ID']+'"]').remove();
            } else {
              whowhere_table.find('tr[data-uip="'+data[i]['WW_U_IP']+'"]').remove();
            }

            newtr = $('<tr data-uid="'+data[i]['WW_U_ID']+'" data-uip="'+data[i]['WW_U_IP']+'" class="not-parsed"></tr>');
            newtr.append('<td>'+data[i]['WW_DATE']+'</td>');
            newtr.append('<td>'+data[i]['WW_U_NAME']+' '+data[i]['WW_U_IP']+'</td>');
            newtr.append('<td>'+data[i]['WW_TITLE']+'</td>');
            newtr.append('<td><a href="'+data[i]['WW_U_MORE']+'">подробнее..</a></td>');

            whowhere_table.prepend(newtr);
          }
          setTimeout(function() {
            whowhere_table.find('.not-parsed').removeClass('not-parsed').addClass('parsed');
          }, 500);
        });
        setTimeout(function() {
          whowhere_update();
        }, 5000);
      }
      $().ready(function() {
        setTimeout(function() {
          whowhere_update();
        }, 2000);
      });
    </script>
    <!-- ENDIF -->
    <style>
      .whowhere_table tr {
        transition: all 1s;
        background-color: yellow;
      }
      .whowhere_table tr.parsed {
        background-color: white;
      }
    </style>
<!-- END: MAIN -->