function catselector_changeselect(obj, area, name, userrigths, rsc)
{
	while($(obj).next('select[name="'+name+'"]').length)
	{
		$(obj).next('select[name="'+name+'"]').remove();
	}
	$.ajax
	({
		url: 'index.php?r=catselector&area='+area+'&userrigths='+userrigths+'&c=' + $(obj).val(),
		beforeSend: function() {

		},
		success: function(data)
		{
			if(data)
			{
				var optHtml = '';
				for (var i = 0; i < data.length; i++) {
					optHtml += '<option value="' + data[i]["id"] + '">' + data[i]["title"] + '</option>';
				}

				if(optHtml > '')
				{
					if(rsc == '0'){
						var onchange_select_set_input = "$('input[name="+name+"]').val($(this).val());";
					}else{
						var onchange_select_set_input = '';
					}
					
					$(obj).after('<select name="'+name+'" onChange="'+onchange_select_set_input+'catselector_changeselect(this, \''+area+'\', \''+name+'\', \''+userrigths+'\', \''+rsc+'\');">' + optHtml + '</select>');
				}
			}
		} 
	});		
}