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

    if ($("#sorter").length) {
        $("#sorter").on('change', function () {
            window.location.href = this.value;
        });
    }
});
