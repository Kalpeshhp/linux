jQuery(document).ready(function ($) {
    $('.home-banner').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false
    });
    $('.build-store-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false
    });

    var windowWidth = $(window).width();
    if (windowWidth < 992) {
        // Do stuff here
        $(document).ready(function () {
            $(".hamburger").click(function () {
                $(this).toggleClass('is-active');
                $('.mobile-menu').toggleClass('open-menu');
                $('.wsmenucontainer').toggleClass('wsoffcanvasopener');

            });
            $(".overlapblackbg").click(function () {
                $('.hamburger').removeClass('is-active');
                $('.mobile-menu').removeClass('open-menu');
                $('.wsmenucontainer').removeClass('wsoffcanvasopener');

            });
            $(".hamburger.is-active").click(function () {
                alert(1);
                $('.hamburger').removeClass('is-active');
                $('.mobile-menu').removeClass('open-menu');
                $('.wsmenucontainer').removeClass('wsoffcanvasopener');

            });
        });
    }
});
