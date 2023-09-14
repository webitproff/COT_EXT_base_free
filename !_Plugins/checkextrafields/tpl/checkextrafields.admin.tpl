<!-- BEGIN: MAIN -->
<div class="container">
  <div class="row">
    <div class="span12">
      <h3>
        <!-- IF {PHP.area} -->
        Конфиг {PHP.area}
        <!-- ELSE -->
        Выберите модуль
        <!-- ENDIF -->
        <a class="pull-right" href="{PHP|cot_url('admin', 'm=other&p=checkextrafields&area=demands')}">Demands</a>
        <a class="pull-right" href="{PHP|cot_url('admin', 'm=other&p=checkextrafields&area=projects')}">Projects</a>
        <a class="pull-right" href="{PHP|cot_url('admin', 'm=other&p=checkextrafields&area=market')}" style="padding-right:10px">Market</a>
        <a class="pull-right" href="{PHP|cot_url('admin', 'm=other&p=checkextrafields&area=page')}" style="padding-right:10px">Page</a>
      </h3>
      {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
      <!-- IF {PHP.area} -->
      <form method="POST" action="{PHP.area|cot_url('admin', 'm=other&p=checkextrafields&a=add&area='$this)}">
        <div class="row">
          <div class="span3">
            Выберите категорию:
          </div>
          <div class="span9">
            {CHK_ADD_CATS}
          </div>
        </div>
        <div class="row">
          <div class="span3">
          </div>
          <div class="span9">
            <div class="well well-small">
              <div>
                <h2>Экстраполя</h2>
                <table class="cells">
                  <tr>
                    <th>Поле:</th>
                    <th>Обязательное заполнение</th>
                  </tr>
                  <tr>
                    <td>Модуль Files:</td>
                    <td>
                     <!-- IF {PHP|cot_module_active('files')} -->
                      <label><input type="radio" name="rchkset[files]" value="0" checked="checked"> Нет</label> <label><input type="radio" name="rchkset[files]" value="1"> Да</label>
                     <!-- ELSE -->
                      Отключен
                     <!-- ENDIF -->
                    </td>
                  </tr>
                  <tr>
                    <td>Плагин Mavatars:</td>
                    <td>
                     <!-- IF {PHP|cot_plugin_active('mavatars')} -->
                      <label><input type="radio" name="rchkset[mavatars]" value="0" checked="checked"> Нет</label> <label><input type="radio" name="rchkset[mavatars]" value="1"> Да</label>
                     <!-- ELSE -->
                      Отключен
                     <!-- ENDIF -->
                    </td>
                  </tr>
                  <!-- BEGIN: EXTRA_ROW -->
                  <tr>
                    <td>{CHK_MOD_EXTRAFLD_TITLE}:</td>
                    <td>{CHK_MOD_EXTRAFLD}</td>
                  </tr>
                  <!-- END: EXTRA_ROW -->
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
      <!-- ENDIF -->
    </div>
  </div>
  <!-- IF {PHP.area} -->
  <div class="row">
    <div class="span3"><b>Категория</b></div>
    <div class="span7"><b>Доступные теги</b></div>
    <div class="span1"><b>Действие</b></div>
    <hr>
  </div>
  <!-- BEGIN: CHK_ROW -->
  <div class="row">
    <div class="span3">
      <br>
      <b>{CHK_ROW_CAT}</b>
    </div>
    <div class="span7">
      <table class="cells">
        <tr>
          <td style="border: 0;">Поле:</td>
          <td style="border: 0;">Обязательное заполнение</td>
        </tr>
        <!-- IF {PHP|cot_module_active('files')} -->
        <tr>
          <td>Модуль Files:</td>
          <td>
            <!-- IF {CHK_ROW_SET|in_array('files', $this)} == 1 --><b>Да</b><!-- ELSE -->Нет<!-- ENDIF -->
          </td>
        </tr>
        <!-- ENDIF -->
        <!-- IF {PHP|cot_plugin_active('mavatars')} -->
        <tr>
          <td>Плагин Mavatars:</td>
          <td>
            <!-- IF {CHK_ROW_SET|in_array('mavatars', $this)} == 1 --><b>Да</b><!-- ELSE -->Нет<!-- ENDIF -->
          </td>
        </tr>
        <!-- ENDIF -->
        <!-- BEGIN: EXTRA_ROW -->
        <tr>
          <td>{CHK_ROW_EXTRAFLD_TITLE}:</td>
          <td>
            <!-- IF {CHK_ROW_EXTRAFLD} == 1 --><b>Да</b><!-- ELSE -->Нет<!-- ENDIF -->
          </td>
        </tr>
        <!-- END: EXTRA_ROW -->
      </table>
    </div>
    <div class="span1">
      <br>
      <a href="{CHK_ROW_DEL_URL}">Удалить</a>
    </div>
  </div>
  <hr>
  <!-- END: CHK_ROW -->
  <!-- ENDIF -->
</div>
<!-- END: MAIN -->