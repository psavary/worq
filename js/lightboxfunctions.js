$(function () {

    $('#lognav').click(function (e) {
        $("#login").lightbox_me({centered: true, preventScroll: true, onLoad: function () {
            $("#login").find("input:first").focus();
        }});

        e.preventDefault();
    });


});