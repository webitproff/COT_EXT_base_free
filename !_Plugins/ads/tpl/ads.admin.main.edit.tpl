<!-- BEGIN: MAIN -->
<div>
    <a href="{PHP|cot_url('admin', 'm=other&p=ads')}">Объявления</a>
    <a href="{PHP|cot_url('admin', 'm=structure&n=ads')}">Категории</a>
    <a href="{PHP.db_ads|cot_url('admin', 'm=extrafields&n=$this')}">Экстраполя</a>
</div>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<div class="block">
	<h3 class="tags">{PAGE_TITLE}</h3>
	<form action="{FORM_ID|cot_url('admin', 'm=other&p=ads&a=edit&id=$this')}" method="POST" ENCTYPE="multipart/form-data">
	   <!-- <input type="hidden" name="rid" value="{FORM_ID}" /> -->
		<input type="hidden" name="act" value="save" />

		<table class="cells">
			<tr>
				<td class="width20">{PHP.L.Title}:</td>
				<td>{FORM_TITLE}</td>
			</tr>
			<tr>
				<td>{PHP.L.Category}:</td>
				<td>{FORM_CATEGORY}</td>
			</tr>
			<tr>
				<td>{PHP.L.Image}:</td>
				<td>
          <!-- IF {FORM_IMAGE} --><div class="marginbottom10"><img src="{FORM_IMAGE}" style="max-height: 200px;" /></div><!-- ENDIF -->
					{FORM_FILE}
				</td>
			</tr>
			<tr>
				<td>{PHP.L.ads_alt}:</td>
				<td>{FORM_ALT}</td>
			</tr>
			<tr>
				<td>{PHP.L.ads_click_url}:</td>
				<td>
         {FORM_CLICKURL}<br>
         <small>В формате http://mysite.ru</small>
        </td>
			</tr>
			<tr>
				<td>{PHP.L.Description}:</td>
				<td>{FORM_DESCRIPTION}</td>
			</tr>
			<tr id="ad_expire">
				<td>{PHP.L.ads_expire}:</td>
				<td>{FORM_PUBLISH_DOWN}</td>
			</tr>
			<tr id="ad_period" style="display:none;">
				<td>{PHP.L.ads_expire_time}:</td>
				<td>{FORM_PERIOD}</td>
			</tr>
			<!-- BEGIN: EXTRAFLD -->
			<tr>
				<td>{FORM_EXTRAFLD_TITLE}:</td>
				<td>{FORM_EXTRAFLD}</td>
			</tr>
			<!-- END: EXTRAFLD -->
			<tr>
				<td>{PHP.L.ads_client}:</td>
				<td>{FORM_CLIENT_ID}</td>
			</tr>
		</table>
		<div class="action_bar valid">
			<button type="submit" class="submit">{PHP.L.Submit}</button>
		</div>
	</form>
  <!-- IF !{FORM_ID} -->
  <script>
   $('[name="ruserid"]').change(function() {
    if($(this).val() != {PHP.usr.id}) {
      $('#ad_expire').hide(); $('#ad_period').show();
    } else {
      $('#ad_period').hide(); $('#ad_expire').show();
    }
   }).change();
  </script>
  <!-- ENDIF -->
<!-- END: MAIN -->