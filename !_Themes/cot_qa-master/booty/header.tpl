<!-- BEGIN: HEADER -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>{HEADER_TITLE}</title> 
<!-- IF {HEADER_META_DESCRIPTION} --><meta name="description" content="{HEADER_META_DESCRIPTION}" /><!-- ENDIF -->
<!-- IF {HEADER_META_KEYWORDS} --><meta name="keywords" content="{HEADER_META_KEYWORDS}" /><!-- ENDIF -->
<meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
<meta name="generator" content="Cotonti http://www.cotonti.com" />
<link rel="canonical" href="{HEADER_CANONICAL_URL}" />
{HEADER_BASEHREF}
{HEADER_HEAD}
<link rel="shortcut icon" href="favicon.ico" />
<link rel="apple-touch-icon" href="apple-touch-icon.png" />
</head>

<body>

	<div id="wrapper" class="container">
		<!-- BEGIN: I18N_LANG -->
		<div class="row">
			<div class="span12">
			<!-- BEGIN: I18N_LANG_ROW -->
			<a href="{I18N_LANG_ROW_URL}" class="{I18N_LANG_ROW_CLASS}"><img src="images/flags/{I18N_LANG_ROW_FLAG}.png"/></a>&nbsp;
			<!-- END: I18N_LANG_ROW -->
			</div>
		</div>
		<!-- END: I18N_LANG -->
		<div id="header" class="row">
			<div class="span6">
				<div class="logo"><a href="{PHP|cot_url('index')}" title="{PHP.cfg.maintitle} {PHP.cfg.separator} {PHP.cfg.subtitle}"><img src="themes/{PHP.theme}/img/logo.png"/></a></div>
			</div>
			<div class="span3">
				
			</div>
			<div class="span3">
				<!-- BEGIN: GUEST -->
				<div class="auth">
					<a href="{PHP|cot_url('login')}">{PHP.L.Login}</a>&nbsp;&#8226;&nbsp;<a href="{PHP|cot_url('users','m=register')}">{PHP.L.Register}</a>
				</div>
				<!-- END: GUEST -->
				<!-- BEGIN: USER -->
				<div class="auth">
					<div><a class="red" href="{PHP|cot_url('users', 'm=profile')}">{PHP.L.Profile}</a></div>
					<div>{HEADER_USER_PMREMINDER}</div>
					<div>{HEADER_USER_ADMINPANEL} {HEADER_USER_LOGINOUT}</div>
				</div>
				<!-- END: USER -->
			</div>
		</div>

		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<ul class="nav">
					<li<!-- IF {PHP.env.ext} == 'index' --> class="active"<!-- ENDIF -->><a href="{PHP.cgf.mainurl}">{PHP.L.Home}</a></li>
					<li<!-- IF {PHP.env.ext} == 'page' AND {PHP.c} == 'questions' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('page','c=questions')}">{PHP.L.Questions}</a></li>
					<!-- IF {PHP.cot_plugins_active.search} -->
					<li<!-- IF {PHP.env.ext} == 'search' --> class="active"<!-- ENDIF -->><a href="{PHP|cot_url('plug','e=search')}">{PHP.L.Search}</a></li>
					<!-- ENDIF -->
				</ul>
			</div>
		</div>
		
		<div id="main" class="content">
		
<!-- END: HEADER -->