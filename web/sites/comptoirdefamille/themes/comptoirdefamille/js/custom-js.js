jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // FAKE LINK FOR SUBMENUS
    $(".js-fake-link").click(function (e) {
        e.preventDefault();
    });

    // NAV MOBILE
    if (isTabletOrLess) {
        $(".navbar-toggler").click(function() {
            $(this).toggleClass("is-active");
            $("#nav-wrapper").toggleClass("active");
            $("#content-wrap > .container-fluid").toggleClass("disable");
            $("body").toggleClass("disable");
        });

        $("#nav-wrapper a.dd").click(function(e) {
            e.preventDefault();
            $(this).toggleClass("opened");
            $(this).parent().find("ul").slideToggle();
        });
    }

    // HP - Slick
    $(".js-slides-wrapper").slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        fade: true,
        cssEase: 'linear'
    });

    // INSTAFEED
    if ($('#instafeed').length) {
        var userFeed = new Instafeed({
            get: 'user',
            userId: '8714008555',
            accessToken: '8714008555.1677ed0.6f4f3907ab5947dd810ed5d0fbf58711',
            limit: 8,
            resolution: 'standard_resolution',
            // Slick
            after: function () {
                $('#instafeed').slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows:false,
                                centerMode: true
                            }
                        }
                    ]
                });
            },
            template:
            '<div>' +
            '<a href="{{link}}" id="{{id}}" target="_blank"><img class="img-fluid" src="{{image}}" />' +
            '<span class="overlay-wrapper"><span>' +
            '<span class="likes">{{likes}}</span>' +
            '<span class="comments">{{comments}}</span>' +
            '</span></span></a>' +
            '</div>'
        });
        userFeed.run();
    }

    // LA MARQUE - Slick
    var marqueSlider = $(".js-slides-ambiances > div > div:nth-child(2)");
    marqueSlider.slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // PAGE CONTACT
    if ($('.webform-submission-form').length) {
        // Function
        var checkValue = function (e) {
            tmpval = e.val();
            if (tmpval === '') {
                e.addClass('js-empty').removeClass('js-not-empty');
            } else {
                e.addClass('js-not-empty').removeClass('js-empty');
            }
        };
        // Var Elts
        var formElts = $('input, textarea');
        // 1er chargement
        formElts.each(function () {
            checkValue($(this));
        });
        // Au clic sur l'elt
        formElts.blur(function () {
            checkValue($(this));
        });
        // Required
        $(".required").parent().addClass("required-wrapper");
    }

    // PARUTION PRESSE
    $(".js-link-pdf").click(function () {
        var link = $(this).attr("data-link");
        $(".js-pdf-embed").attr("src",link);
    });

    // STORE LOCATOR
    if ($(".store-locator").length) {
        $(this).on("click", '.phone', function(e) {
            e.preventDefault();
            $(".txt").toggle();
            $(".number").toggle();
        });
    }
});