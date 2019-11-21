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

    // QSN - FADEGALERY
    var galery = ".js-fade-galery img";
    if ($(galery).length) {
        $(galery + ":first-child").addClass("current");
        setInterval(elemAnim, 5000);

        function elemAnim() {
            var current = $(galery + ".current");
            var next = current.next();

            current.toggleClass("current");
            if (current.is($(galery + ":last-child"))) {
                next = $(galery + ":first-child");
            }
            next.toggleClass("current");
        }
    }

    // BRANDS - SLICK
    var sliderBrand = $(".brands .js-slick > div");
    sliderBrand.slick({
        slidesToShow: 4,
        arrows: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    centerMode: true,
                    centerPadding: '60px'
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    centerMode: true
                }
            }
        ]
    });
});