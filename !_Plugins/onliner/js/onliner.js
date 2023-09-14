function ShowOnliner()
{
	$.ajax
	({
		url: "index.php?r=onliner",
		beforeSend: function() {
			
		},
		success: function(data)
		{
			$("#onliner").html(data);
		} 
	});
	
	setTimeout(ShowOnliner, 30000);
}

$(function() {
	$("#footer").append('<div id="onliner"></div>');
	ShowOnliner();
});