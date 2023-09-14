<!-- BEGIN: MAIN -->
<div style="font-size: 14px;font-weight: normal;">
    
<!-- IF {USERS_DETAILS_ISPRO} -->
<div>
<i class="icon icon-user"></i> Аккаунт <span class="label label-success pull-right">PRO</span>
</div>
<!-- ENDIF -->

<div>
<i class="icon icon-signal"></i> Рейтинг <b class="pull-right">{USERS_DETAILS_USERPOINTS}</b>
</div>

<div>
    <i class="icon icon-comment"></i> Отзывы
    <b class="pull-right"> 
      <span class="text-success">+{USERS_DETAILS_REVIEWS_POZITIVE_SUMM}</span>
       <span class="text-danger">-{USERS_DETAILS_REVIEWS_NEGATIVE_SUMM}</span>
    </b>   
</div>

<!-- IF {USERS_DETAILS_VRF_STATUS} -->
<div><i class="fa fa-shield" style="padding: 0px 2px;"></i> {USERS_DETAILS_VRF_STATUS}</div>
<!-- ENDIF -->

<br />
<dl>
  <dt>Специализации:</dt>
  {USERS_DETAILS_CATS|cot_usercategories_catlist($this)}
</dl>

</div>
<div class="clearfix"></div>
<!-- END: MAIN -->