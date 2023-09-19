$(document).ready(function() {
    // var fixmeTop = $('.navbar-finalstyle').offset().top;
    // console.log(fixmeTop);
    $(window).scroll(function() {
        var currentScroll = $(window).scrollTop();
        if (currentScroll >= 30) {
            $('.navbar-finalstyle').addClass('active-menu');
        } else {
            $('.navbar-finalstyle').removeClass('active-menu');
        }
    });

    new Mmenu(document.querySelector("#menu-mobile"));

    $('#change_locale').on('change', function () {
        window.location =  $(this).val();
    })
});
