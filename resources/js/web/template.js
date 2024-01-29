$('.header-main-dropdown .dropdown-item').click(function() {
    let content = $(this).text();
    $('.form-drop-btn span').text(content)
})

$('.menu-site').hover(function() {
    $('body').append('<div class="overlay"></div>')
}, function(){
    $('body .overlay').remove();
})

$(window).scroll(function () {
    if ($(this).scrollTop() > 1) {
        $('.header-main').addClass('is-sticky');
        $('.header-main-logo').fadeOut(0);
        $('.header-main-logo-icon').fadeIn(0);
        $('.header-main .header-menu').fadeIn(0);
        $('.header-main .menu-call-hotline').fadeOut(0);
    } else {
        $('.header-main').removeClass('is-sticky');
        $('.header-main-logo').fadeIn(0);
        $('.header-main-logo-icon').fadeOut(0);
        $('.header-main .header-menu').fadeOut(0);
        $('.header-main .menu-call-hotline').fadeIn(0);
    }
});