$(document).ready(function(){
  $('body').on('hover', 'a.ajaxpopover, .ajaxpopover > a, .ajaxpopover[href]', function(event){
      if (event.type === 'mouseenter') {
          var el=$(this);
              el.addClass('mousepopover');
          var fn_ajaxpopover = function(el, data) {
            el.popover({
              content: data,
              html: true,
              container: 'body',
              placement: 'top',
            }).popover('show');
          };
          if(typeof el.data('ajaxpopover') != 'undefined') {
            fn_ajaxpopover(el, el.data('ajaxpopover'));
          } else {
            var url = el.attr('href');
                url += (url.indexOf('?') == -1 ? '?' : '&') + 'popover=1';
            $.get(url,function(d){
              el.data('ajaxpopover', d);
              if (el.hasClass('mousepopover')) {
                fn_ajaxpopover(el, d);
              }
            });
          }
      } else {
        $(this).removeClass('mousepopover').popover('hide');
      }
  });
});
