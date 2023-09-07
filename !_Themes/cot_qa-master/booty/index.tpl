<!-- BEGIN: MAIN -->
	
	<div class="well well-large">
		{PHP.L.index_text}
	</div>
	
	<br/>
	<div class="row">
		<div class="span9">
			<h3>{PHP.L.Questions}</h3>
			{INDEX_NEWS_QUESTIONS}
		</div>
		<div class="span3">
			<a href="<!-- IF {PHP|cot_auth('page', 'questions', 'W')} > 0 -->{PHP|cot_url('page','m=add&c=questions')}<!-- ELSE -->{PHP|cot_url('login')}<!-- ENDIF -->" class="btn btn-primary btn-block btn-large">{PHP.L.question_add}</a>
			<br/>
			{PLUGIN_TOPEXPERTS}
			{PLUGIN_TOPQUESTIONS}
			{PLUGIN_TOPANSWERS}
			
			
			<!-- IF {INDEX_TAG_CLOUD} -->
			<div class="block">
				<h4>{PHP.L.Tags}</h4>
				{INDEX_TAG_CLOUD}
			</div>
			<!-- ENDIF -->
			
		</div>
	</div>
	
<!-- END: MAIN -->