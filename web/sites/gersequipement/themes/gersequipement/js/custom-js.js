jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

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

    if ( isTabletOrLess ) {
        // NAV MOBILE
        var $menu = $("#block-gersequipement-main-menu").mmenu({
            "extensions": [
                "theme-white",
                "border-full",
                "position-front",
                "pagedim-black",
                "fullscreen",
                "position-right"
            ]
        }, {
            clone: true
        });

        var $icon = $(".navbar-toggler");
        var API = $menu.data("mmenu");

        API.bind( "open:start", function() {
            setTimeout(function() {
                $icon.addClass( "is-active" );
                $icon.on("click",function() {
                    API.close();
                })
            }, 100);
        });
        API.bind( "close:start", function() {
            setTimeout(function() {
                $icon.removeClass( "is-active" );
            }, 100);
        });
    }

    // ANCHORS SMOOTH
    $(function() {
        // ON LOAD
        function smoothScrollTo(target) {
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1500);
            }
        }
        if ((location.hash) && (!$(".univers").length)) {
            window.scrollTo(0, 0);
            target = location.hash.split('#');
            smoothScrollTo($('#'+target[1]));
        }

        // ON CLICK
        $("a[href*='#']:not([href='#']):not('.navbar-toggler')").click(function() {
            if (
                location.hostname == this.hostname
                && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
            ) {
                var anchor = $(this.hash);
                anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
                if ( anchor.length ) {
                    $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
                }
            }
        });
    });

    // HACK AUTOPLAY VIDEO HP
    const videoHomepage = $('#video-hp');
    if (videoHomepage.length) {
        videoHomepage.get(0).play();
    }

    // SLIDER HP
    var sliderHPLeft = $(".js-slick-slider-hp-left");
    var sliderHPRight = $(".js-slick-slider-hp-right");
    var sliderHPActu = $(".js-slider-actu");
    var sliderHPMobile = $(".js-slick-slider-hp-mobile");
    var sliderHpCta = $(".js-slick-hp-cta");
    var sliderHpCtaBrands = $(".js-slideshow-brand");
    var sliderHpCtaConcepts = $(".js-slideshow-concepts");

    var sliderHP = function(slider, verticalReverse) {
        slider.slick({
            vertical: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            verticalReverse: verticalReverse,
            infinite: true,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 1200
        });
    };

    sliderHP(sliderHPLeft, false);
    sliderHP(sliderHPRight, true);

    sliderHPMobile.slick({
        infinite: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
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

    sliderHPActu.slick({
        infinite: true
    });

    // HP - Mini slideshow brands
    var sliderHPCtaSVG = function(slider) {
        slider.slick({
            arrows: false,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 3000
        });
    };

    sliderHPCtaSVG(sliderHpCtaConcepts);
    sliderHPCtaSVG(sliderHpCtaBrands);

    sliderHpCta.slick({
        slidesToShow: 4,
        arrows: false,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
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

    // OUR JOBS - CUSTOM TABS
    var tabsWrapper = ".js-tabs-wrapper";
    var tab = tabsWrapper + " .js-tab";
    var tabHiddenContent = tab + " .js-hidden-content";
    var jobsGalery = $('.js-slick-jobs > div');

    function hideContents() {
        if (isTabletOrLess) {
            $(tabHiddenContent).slideUp('fast');
        } else {
            $(tabHiddenContent).fadeOut();
        }
    }

    if ($(tabsWrapper).length) {
        $(tab).on("click", function() {
            hideContents();
            if (isTabletOrLess) {
                if ($(this).hasClass("active")) {
                    $(tab).removeClass("active");
                } else {
                    $(tab).removeClass("active");
                    $(this).addClass("active");
                    $(this).children(".js-hidden-content").slideDown('fast');
                }
            } else {
                $(this).removeClass("js-tab");
                $(this).children(".js-hidden-content").fadeIn();
            }
        });

        $(".js-close").on("click", function (e) {
            $(".tab").addClass("js-tab");
            e.stopPropagation();
            hideContents();
        });
    }

    jobsGalery.slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 1500,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    autoplay: false,
                    arrows: false,
                    centerMode: true,
                    centerPadding: '60px'
                }
            },
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                    autoplay: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: true
                }
            }
        ]
    });

    // NOS UNIVERS
    var universLabel = ".js-univers-label";
    if ($(universLabel).length) {
        var univers = ".js-univers";
        var hash = window.location.hash.replace('#', '');
        if (isTabletOrLess) {
            function hideUnivers() {
                $(univers).removeClass("active");
                $(univers + " .js-content").slideUp();
                $('html, body').animate({scrollTop:0}, 'fast');
            }
            // via URL
            if (hash) {
                hideUnivers();
                $(univers + "[data-label='" + hash + "']").addClass("active");
                $(univers + "[data-label='" + hash + "']").children(".js-content").slideDown({
                    start: function () {
                        $(this).css({
                            display: "flex"
                        })
                    }
                });
            }
            // via click
            $(univers).on("click", function() {
                if ($(this).hasClass("active")) {
                    hideUnivers();
                } else {
                    hideUnivers();
                    $(this).addClass("active");
                    $(this).children(".js-content").slideDown({
                        start: function () {
                            $(this).css({
                                display: "flex"
                            })
                        }
                    });
                }
            });
        } else {
            // via URL
            if (hash) {
                $(universLabel + " .label").removeClass("active");
                $(universLabel + "[data-label='" + hash + "'] .label").addClass("active");
                $(univers).hide();
                $(univers + "[data-label='" + hash + "']").show();
            }
            // via click
            $(universLabel).on("click", function () {
                var index = $(this).index();
                var selectedUnivers = $(univers + ":nth-child(" + ( index + 1 ) + ")");
                $(universLabel + " .label").removeClass("active");
                $(this).children(".label").addClass("active");
                $(univers).hide();
                $(selectedUnivers).show();
            });
        }

    }


    // FORMS
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
});