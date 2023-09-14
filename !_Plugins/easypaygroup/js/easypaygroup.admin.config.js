var num = 1; 

function changeareas()
{
	var areastext = '';
	var unsetareas = '';
	num = $('#areagenerator .area').length;

	$('#areagenerator .area').each(function(i) {
		var area_group = $(this).find('.code_group').val();
		var area_name = $(this).find('.code_name').val();		
		var area_time = $(this).find('.code_time').val();
    var area_cost = $(this).find('.code_cost').val();

		if (area_group > '' && area_name > '')
		{
			areastext += area_group + '|' + area_name + '|' + area_time + '|' + area_cost;
			if (i + 1 < num) areastext +=  '\r\n';
		}
	});
	if(areastext > '')
	{
		$('[name=codes]').val(areastext);
	}
}

$(".deloption").live("click", function () {
	$(this).closest('tr').remove();
	changeareas();
	return false;
});

$('#addoption').live("click", function(){
	var object = $('.area').last().clone();
	$(object).find('.deloption').show();
	$(object).find('input[type=text]').val('');
	$(object).find('input[type=checkbox]').attr('checked', false);
	$(object).insertBefore('#addtr').show();
	changeareas();
	return false;
});
	
$('input[type=text], input[type=checkbox]').live("change", function(){
	changeareas();
});
$('input[type=checkbox]').live("click", function(){
	changeareas();
});
$('select').live("change", function(){
	changeareas();
});

$(document).ready(function(){
	$('#areagenerator').show().prependTo($('form#saveconfig'));
	$('[name=codes]').closest('tr').hide();

	changeareas();
});