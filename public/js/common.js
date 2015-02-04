$(function () {

    $("#login").hide();
    
    $("[data-toggle=login]").popover({
        html: true,
        trigger: 'click',
        content: function () {
            return $('#login').html();
        }
    });
    
    if ($(".login-error").length) {
        $("[data-toggle=login]").trigger('click');
    }
});
