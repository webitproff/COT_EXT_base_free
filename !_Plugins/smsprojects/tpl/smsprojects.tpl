<!-- BEGIN: MAIN -->

<div class="breadcrumb">{PHP.L.smsprojects}</div>
<h1>{PHP.L.smsprojects_title}</h1>

<!-- IF {SMSSENDING_ENABLED} -->

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<form action="{SMSPRJ_FORM_ACTION}" method="post">
	<p>{PHP.L.smsprojects_phone}</p>
	{SMSPRJ_FORM_PHONE}
	<p><i>{PHP.L.smsprojects_phoneformat}</i></p>
	<br/>
	<p>{PHP.L.smsprojects_desc}</p>
	
	{SMSPRJ_FORM_CATS}
	<br/>
	<button class="btn btn-success">{PHP.L.Submit}</button>
</form>

<!-- ELSE -->

<div class="alert alert-warning">
	{PHP.L.smsprojects_forpro_noaccess}
</div>

<!-- ENDIF -->

<!-- END: MAIN -->