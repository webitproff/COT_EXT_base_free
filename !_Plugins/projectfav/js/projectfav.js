$().ready(function () {
     $('[data-toggleprojectfav]').click(function (e) {
        e.preventDefault();
        $this = $(this);
        $.get($this.attr("href"), function (h) {
            var res = JSON.parse(h);
            if(res.status = 'success') $this.html(res.text);
        });
    });
});
