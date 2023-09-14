$(".div_paytop_time").hide();

function calProjectCost() {
	var prj, paytop, ishot;

	prj = parseInt($('[data-calc-project]').attr('data-calc-project'));
	if ($('input[name="paytop"]').is(':checked')) {
		paytop = parseInt($('[data-calc-paytop]').attr('data-calc-paytop')) * parseInt($('input[name="days"]').val());
	} else {
		paytop = 0;
	}
	if ($('input[name="ritemishot"]').is(':checked')) {
		ishot = parseInt($('[data-calc-ishot]').attr('data-calc-ishot'));
	} else {
		ishot = 0;
	}

	$("#prj_end_cost").text(prj + paytop + ishot);
}
$('input[name="days"]').change(function() {
	calProjectCost();
});
$('input[name="paytop"]').click(function() {
	if ($('input[name="paytop"]').is(':checked')) {
		$(".div_paytop_time").show();
	} else {
		$(".div_paytop_time").hide();
	}
	calProjectCost();
});
$('[data-calc-ishot]').click(function() {
	calProjectCost();
});