jQuery(document).ready(function($) {
    // NAV
    var timerNav;
    $(".header-wrapper nav").hover(
        function() {
            timerNav = setTimeout(function() {
                $(".header-wrapper").addClass("menu-hover");
            }, 400);
        },
        function() {
            $(".header-wrapper").removeClass("menu-hover");
            clearTimeout(timerNav);
        }
    );

    // SLIDER HP
    var sliderHPLeft = $(".js-slick-slider-hp-left > div");
    var sliderHPRight = $(".js-slick-slider-hp-right > div");
    var sliderHPActu = $(".js-slider-actu");

    sliderHPLeft.slick({
        vertical: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 1200
    });

    sliderHPRight.slick({
        vertical: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        verticalReverse: true,
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 1200
    });

    sliderHPActu.slick({
        infinite: true
    });


});