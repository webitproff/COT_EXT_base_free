<!-- BEGIN: MAIN -->

<html>
  <head>
    <title>Лучшие пилоты для вашего заказа</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <meta property="og:title" content="{PHP.out.ogtitle}"/>
    <meta property="og:image" content="{PHP.out.ogimage}"/>

    <base href="{PHP.cfg.mainurl}" />

    {HEADER_HEAD}
    {HEADER_TOPLINE}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.4/css/uikit.min.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="/themes/pilothub/js/validate/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.4/js/uikit.min.js"></script>

    <link href="/themes/pilothub/css/default.css" type="text/css" rel="stylesheet" />
    <link href="/themes/pilothub/css/main.css" type="text/css" rel="stylesheet" />

    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="apple-touch-icon" href="apple-touch-icon.png" />
  </head>
  <body class="page request">
    {PHP.cfg.topline}
    <div class="wrapper bg_white">
      <div class="align_center p-v_25">
        <a href="{PHP|cot_url('index')}"><img src="/themes/{PHP.theme}/files/img/logo.png" /></a>
      </div>
      <div class="align_center p-v_25">
        <a href="{PHP|cot_url('folio')}" class="p-s_20 t-d_ul">ФОТО И ВИДЕО</a>
        <a href="{PHP|cot_url('users', 'group=pilot')}" class="p-s_20 t-d_ul">ПИЛОТЫ</a>
        <a href="{PHP|cot_url('market')}" class="p-s_20 t-d_ul">ОБЪЯВЛЕНИЯ</a>
      </div>
      <div class="cntnr">
        <div class="cntnr_top bg" style="min-height: 140px!important;">
          <div class="content-block col_12 align_center">
            <h1 class="f-s_28 m-t_30 color_white">Мы нашли исполнителей на ваш заказ</h1>
          </div>
        </div>
      </div>
      <div class="align_center p-v_25 f-s_18 color_dark">
        Здравствуйте, {PHP.request.request_name}! Спасибо, что воспользовались сервисом Pilothub и разместили заказ:
        <h2 class="f-s_20 p-v_20">{PHP.request.item_title}, г. {PHP.request.item_city|cot_getcity($this)}</h2>
        Мы нашли лучших пилотов для вашего заказ и вам осталось только выбрать одного из них:
        <br/>
        <br/>
        <br/>
        <div class="request_offers_pilots">
          <!-- BEGIN: PILOT_ROW -->
          <div class="item d_i-b p-v_20 p-s_20">
            <div class="m-b_20"><a href="{PILOT_ROW_DETAILSLINK}" target="_blank">{PILOT_ROW_AVATAR}</a></div>
            <div class="f-s_24"><a href="{PILOT_ROW_DETAILSLINK}" target="_blank">{PILOT_ROW_NICKNAME}</a></div>
            <div class="p-v_10 f-s_16">{PILOT_ROW_COST_FULL} рублей</div>
            <div class="p-b_20 f-s_14"><a href="{PILOT_ROW_DETAILSLINK}" target="_blank">Портфолио</a></div>
            <div class="p-b_20 f-s_14">{PILOT_ROW_COMMENT}</div>
            <!-- IF {PILOT_ROW_DISTANCE} > 0 -->
            <div class="p-b_20 f-s_14"><img src="themes/{PHP.theme}/files/img/portfolio-item_loc.png" /> {PILOT_ROW_DISTANCE} км</div>
            <!-- ENDIF -->
            <div>
            <!-- IF {PHP.request.request_status} != 'paid' -->
            <a href="#pilot_{PILOT_ROW_ID}" data-uk-modal class="btn btn_green f-s_14 l-h_17 h_40 m_col_12 m_m-t_10" onclick="yaCounter38130695.reachGoal('pay-ready'); return true;">Выбрать пилота</a>

            <div id="pilot_{PILOT_ROW_ID}" class="uk-modal">
              <div class="uk-modal-dialog">
                <a class="uk-modal-close uk-close"></a>
                <div>Вы выбрали исполнителя для заказа</div>
                <h2 class="f-s_20 f-w_b p-v_20">{PHP.request.item_title},<br/>г. {PHP.request.item_city|cot_getcity($this)}</h2>
                <div class="m-b_20 m-t_30"><a href="{PILOT_ROW_DETAILSLINK}" target="_blank">{PILOT_ROW_AVATAR}</a></div>
                <div class="f-s_24"><a href="{PILOT_ROW_DETAILSLINK}" target="_blank">{PILOT_ROW_NICKNAME}</a></div>
                <div class="p-v_10 f-s_16 m-b_30">Стоимость съемки: {PILOT_ROW_COST_FULL} рублей</div>
                <div class="m-b_30">Для подтверждения заказа<br/>внесите предоплату {PHP.cfg.plugin.request.tax}%</div>
                <form action="{PILOT_ROW_BUY_URL}" method="get" id="form_buy_{PILOT_ROW_ID}">
                  <input type="hidden" name="a" value="buy" />
                  <input type="hidden" name="performer" value="{PHP.pilot.user_id}" />
                  <input type="hidden" name="rpaymenttype" value="" />
                  <div class="paytypes">
                    <div class="row">
                      <div class="col_3 m_col_12 d_b p-b_10 m_p-b_0 align_right p-l_17 m_align_left color_000 f-s_12">Сумма</div>
                      <div class="col_6 m_col_12 d_b p-b_10 align_center">
                        {PILOT_ROW_COST_TAX} рублей
                      </div>
                      <div class="col_3 m_col_12 d_b p-b_10 m_p-b_0 align_right m_align_left color_000 f-s_12"></div>
                    </div>
                    <div class="row">
                      <div class="col_3 m_col_12 d_b p-b_10 m_p-b_0 align_right l-h_40 p-l_17 m_align_left color_000 f-s_12">Способ оплаты</div>
                      <div class="col_9 m_col_12 d_b p-b_10 align_center">
                        <div class="switch">
                          <div class="item" onclick="$('input[name=rpaymenttype]').val('PC'); $('.switch .item').removeClass('active'); $(this).addClass('active');"><img src="themes/{PHP.theme}/files/img/ym.png" alt=""></div>
                          <div class="item p-t_7" onclick="$('input[name=rpaymenttype]').val('AC'); $('.switch .item').removeClass('active'); $(this).addClass('active');"><img src="themes/{PHP.theme}/files/img/visa-master.png" alt=""></div>
                          <div class="item p-t_7" onclick="$('input[name=rpaymenttype]').val('MC'); $('.switch .item').removeClass('active'); $(this).addClass('active');"><img src="themes/{PHP.theme}/files/img/mobile.png" alt=""></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <span class="checkbox_wrap big m-t_8 agreement customblock">
                      <input type="checkbox" name="ruseragreement" id="id-{PILOT_ROW_ID}">
                      <label for="id-{PILOT_ROW_ID}" class="color_000">Я ознакомлен с <a href="{PHP|cot_url('useragreement')}" target="blank" class="color_blue t-d_n">Пользовательским соглашением</a></label>
                    </span>
                  </div>
                  <button class="btn btn_green f-s_28 l-h_17 h_40 m_col_12 m-t_30 m-b_30">Заказать съемку</button>
                  <div class="f-s_14">Мы вернем деньги, если вас не устроит съемка.</div>
                </div>
              </form>

              <script type="text/javascript">

              $().ready(function() {

                  $("#form_buy_{PILOT_ROW_ID}").validate({
                      ignore: [],
                      rules: {
                          ruseragreement: {
                              required: true,
                          },
                      },
                      messages: {
                          ruseragreement: "Необходимо ознакомиться с пользовательским соглашением",
                      },
                      errorPlacement: function(error, element) {
                          if(element.parents('.input-group').length || element.parents('.selected').length || element.parents('.customblock').length) {

                              if(element.parents('.input-group').length) {
                                  error.insertAfter(element.parents('.input-group'));
                              }

                              if(element.parents('.selected').length) {
                                  error.insertAfter(element.parents('.selected'));
                              }

                              if(element.parents('.customblock').length) {
                                  error.insertAfter(element.parents('.customblock'));
                              } 

                          } else {
                              error.insertAfter(element);             
                          }
                      },
                      submitHandler: function(form) {
                          yaCounter38130695.reachGoal('pay-confirm');
                          form.submit();
                      },
                  });
              });

              </script>
            </div>

            <!-- ELSE -->
              <!-- IF {PHP.request.request_performer} == {PILOT_ROW_ID} -->
              <b class="color_green">Пилот выбран</b>

              <script type="text/javascript">
                $().ready(function() {
                  if(window.location.hash == '#request-paid'){
                    yaCounter38130695.reachGoal('pay-succes');
                    history.pushState('', document.title, window.location.pathname);
                  }
                });
              </script>
              <!-- ENDIF -->
            <!-- ENDIF -->
            </div>
          </div>
          <!-- END: PILOT_ROW -->
        </div>
      </div>
    </div>

  </body>
</html>

<!-- END: MAIN -->