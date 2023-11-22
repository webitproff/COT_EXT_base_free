<!-- BEGIN: MAIN -->

<!-- IF {PHP.m} == 'sent' -->
	<div class="row">
	  <div class="col_12 m_p-v_15 p-b_80">
	    <br/>
	    <br/>
	    <br/>
	    <br/>
	    <p class="f-s_18 align_center">Большое спасибо за заказ!<br/>В течение часа мы свяжемся с вами и подтвердим вашу заявку.</p>
	  </div>
	</div>
<!-- ELSE -->

<div class="content bg_white m_p_0">
  <div class="row m_p-v_25 align_center m_p_0">
    <div class="col_12 bg_white m-t_20 m-w_676 align_left m-b_32 m_p-s_0 m_m_0">
  	    <form action="{FORM_SEND}" method="post" name="form_request" id="form_request">
  	      <div class="row_title align_left p-b_0 p-t_13 t-t_none color_dark m_p-v_15 m_align_center">Заказать съемку с квадрокоптера</div>
            <div class="d_i-b w_380 m_col_12">
      	      <div class="col_12 p-b_10 p-t_30 align_left">
      	        <div class="f-s_18 color_blacked f-w_b p-b_6 align_left m_col_12 m_align_left m_p-b_10">Что снимаем?</div>
      	        {FORM_TITLE|cot_rc_modify($this, 'class="text-form f-s_14 default w_370 col_12 d_i-b m_col_12"  placeholder="Объект съемки"')}
      	      </div>
              <div class="col_12 p-b_10 p-t_10 align_left">
                <div class="f-s_18 color_blacked f-w_b p-b_6 align_left m_col_12 m_align_left m_m-t_20 m_p-b_10">Когда планируется съемка</div>
                {FORM_DEADLINE|cot_rc_modify($this, 'class="text-form w_200 f-s_14 default col_12 d_i-b m_m-b_20 m_col_12 datepicker" placeholder="Свободная дата"')}
              </div>
              <div class="col_12 p-b_10 p-t_10 align_left">
                <div class="f-s_18 color_blacked f-w_b p-b_6 align_left m_col_12 m_align_left m_m-t_20 m_p-b_10">Как вас зовут?</div>
                {FORM_NAME|cot_rc_modify($this, 'class="text-form f-s_14 default w_240 m_col_12 m-r_16 m_m-r_0" placeholder="Ваше имя"')}
              </div>
              <div class="col_12 p-b_10 p-t_10 align_left">
                <div class="f-s_18 color_blacked f-w_b p-b_6 align_left m_col_12 m_align_left m_m-t_20 m_p-b_10">Телефон</div>
                {FORM_PHONE|cot_rc_modify($this, 'class="text-form f-s_14 default w_240 m_col_12" placeholder="Номер телефона"')}
              </div>
      	      <div class="col_12 p-b_10 p-t_10 align_left">
      	        <div class="f-s_18 color_blacked f-w_b p-b_6 align_left m_col_12 m_align_left m_m-t_20 m_p-b_10">Email</div>
                {FORM_EMAIL|cot_rc_modify($this, 'class="text-form f-s_14 default w_240 m_col_12" placeholder="Email"')}
      	      </div>
            </div>
            <div class="inline w_260 p-l_20 m_col_12 m_p-s_15">
              <ul class="ordersteps color_gray f-w_b m_hide">
                <li><i>1</i> <span class="p-t_13">Отправьте заявку</span></li>
                <li><i>2</i> <span class="p-t_5">Мы позвоним и уточним детали заказа</span></li>
                <li><i>3</i> <span class="p-t_5">Выбираете пилота по цене, портфолио и опыту</span></li>
                <li><i>4</i> <span class="p-t_5">Оплачиваете съемку и получаете материалы</span></li>
              </ul>
            </div>
    	      <div class="col_12 p-v_30 m_p-v_25 align_center">
    	        <button class="btn btn_green m-r_20 m_m-r_0 m_col_12">Отправить заявку</button>
            </div>
            <ul class="ordersteps color_gray f-w_b m_show">
              <li><i>1</i> <span class="p-t_13">Отправьте заявку</span></li>
              <li><i>2</i> <span class="p-t_5">Мы позвоним и уточним детали заказа</span></li>
              <li><i>3</i> <span class="p-t_5">Выбираете пилота по цене, портфолио и опыту</span></li>
              <li><i>4</i> <span class="p-t_5">Оплачиваете съемку и получаете материалы</span></li>
            </ul>
          </div>
  	    </form>
    </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  </div>
</div>

<script type="text/javascript">

$().ready(function() {

    $(".datepicker").datepicker({
      dateFormat: "dd.mm.yy",
      buttonText: "Choose",
      minDate: '+1d'
    });

    $("#form_request").validate({
        ignore: [],
        rules: {
            rtitle: {
                required: true,
            },
            rname: {
                required: true,
            },
            rphone: {
                required: true,
            },
            remail: {
                required: true,
                email: true,
            },
        },
        messages: {
            rtitle: "Укажите объект съемки",
            rname: "Укажите ваше имя",
            rphone: "Укажите номер телефона",
            remail: "Укажите вашу почту",
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
            yaCounter38130695.reachGoal('publish-order');
            form.submit();
        },
    });
});

</script>

<!-- ENDIF -->

<!-- END: MAIN -->