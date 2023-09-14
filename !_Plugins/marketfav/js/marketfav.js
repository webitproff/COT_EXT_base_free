$(function () {
     $('[data-togglefavorite]').submit(function () {
        $this = $(this);
        $.ajax({
            url: $this.attr("action"),
            method: "post",
        }).done(function (h) {
            console.log(h);
            var res = $.parseJSON(h);
            console.log(res);
            UIkit.notify(res.text, res.info);
        });
        return false;
    });
});
