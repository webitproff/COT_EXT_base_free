$(document).ready(function() {
$('.reviewstar').raty({
  score: function() {
    return $(this).attr('data-number');
  },
  readOnly: true,
});
});
