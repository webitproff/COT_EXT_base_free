<!-- BEGIN: MAIN -->
<script>
 $(document).ready(function(){
	$(".editableoffer")
		.click(function(event) {
			var $editable = $(this);
			if($editable.hasClass('active')) {
				return;
			}
			var contents = $.trim($editable.html().replace(/\/p>/g,"/p>\n\n"));
			$editable
				.addClass('active')
				.empty();
			
			var editElement = '<textarea style="max-width:600px"></textarea>';
       
			$(editElement)
				.val(contents)
				.appendTo($editable)
				.focus()
				.blur(function(event) {
					$editable.trigger('blur');
				});
		  })	
		.blur(function(event) {
			var $editable = $(this);	
			var edited = $editable.find(':first-child').val();
        $.ajax({
            type: 'GET',
            url: 'admin.php?m=other&p=offerspost&a=edit&id=' + $editable.attr('data-offer-id') + '&text=' + edited,
            success: function (data) {
					    $editable
						   .removeClass('active')
						   .children()
						   .replaceWith(edited);
            },
        })
		});
});
</script>

<div id="offers">	
	<h4>{PHP.L.offers_offers}</h4><br/>
	<!-- BEGIN: ROWS -->
	<div class="row">
		<div class="span1">
			{OFFER_ROW_OWNER_AVATAR}
		</div>
		<div class="span11">
			<p class="owner">{OFFER_ROW_OWNER_NAME} <span class="date">[{OFFER_ROW_DATE}] &nbsp; {OFFER_ROW_EDIT}</span></p>
			<p>
				<!-- IF {OFFER_ROW_OWNER_ISPRO} -->
				<span class="label label-important">PRO</span> 
				<!-- ENDIF -->
				<span class="label label-info">{OFFER_ROW_OWNER_USERPOINTS}</span>
			</p>
			<p class="text">{OFFER_ROW_TEXT}</p>
			<p class="cost">
				<!-- IF {OFFER_ROW_COSTMAX} == {OFFER_ROW_COSTMIN} AND {OFFER_ROW_COSTMIN} != 0 OR {OFFER_ROW_COSTMAX} == 0 AND {OFFER_ROW_COSTMIN} != 0 -->
				{PHP.L.offers_budget}: {OFFER_ROW_COSTMIN} {PHP.cfg.payments.valuta}
				<!-- ENDIF -->
			</p>
			<p>
				<a href="{OFFER_ROW_PRJ_URL}">Заказ</a>
			</p>
			<!-- BEGIN: POSTS -->
			<h5>{PHP.L.offers_posts_title}</h5>
			<div id="projectsposts">
				<!-- BEGIN: POSTS_ROWS -->
				<div class="row">
					<div class="span1">{POST_ROW_OWNER_AVATAR}</div>
					<div class="span10">
						<p class="owner">{POST_ROW_OWNER_NAME} <span class="date">[{POST_ROW_DATE}] <!-- IF {POST_ROW_NEW} --><span class="label label-important">NEW</span> <!-- ENDIF -->&nbsp; {POST_ROW_EDIT_URL}</span></p> 
						<div class="editableoffer" data-offer-id="{POST_ROW_ID}">{POST_ROW_TEXT}</div>
					</div>
				</div>
				<hr/>
				<!-- END: POSTS_ROWS -->

				<!-- BEGIN: POSTFORM -->
				<div class="postform customform" id="postform{ADDPOST_OFFERID}">
					<form action="{ADDPOST_ACTION_URL}" method="post">
						{ADDPOST_TEXT}<br/>
						<input type="submit" name="submit" class="btn" value="{PHP.L.Submit}" />
					</form>
				</div>
				<!-- END: POSTFORM -->
			</div>

			<!-- END: POSTS -->
			
		</div>
	</div>
	<!-- END: ROWS -->
</div>

<!-- END: MAIN -->