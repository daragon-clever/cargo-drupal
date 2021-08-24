// TEST MOBILE / TAB
var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

// MMENU
if (isTabletOrLess) {
    document.addEventListener(
        "DOMContentLoaded", function () {
            new Mmenu("#block-cotetable-main-menu", {
                "extensions": [
                    "border-full",
                    "position-front",
                    "fullscreen",
                    "position-right"
                ],
                "autoHeight": true
            });
        }
    );
}

jQuery(document).on('readystatechange', readyStateChanged);

// LOADER
function readyStateChanged() {
    const bar = document.getElementById("bar-js");
    let width = 1;
    const id = setInterval(frame, 10);

    function frame() {
        if (width >= 100) {
            clearInterval(id);
        } else {
            width++;
            if (document.readyState === 'complete') {
                bar.style.width = "100%";
            } else {
                bar.style.width = width + "%";
            }
        }
    }

    (function ($) {
        if (document.readyState === 'complete') {
            $('.loader-content').fadeOut('slow');
            document.getElementById('loader').style.overflow = 'unset';
        }
    })(jQuery);
}

jQuery(document).ready(function ($) {
    // HEADER N2
    let menuLink = $("#block-cotetable-main-menu > ul > li");
    menuLink.hover(function () {
        $(this).addClass("current")
    }, function () {
        setTimeout(() => {
            $(this).removeClass("current")
        }, 500)
    });

    // MESSAGE BANNER
    if ($('.message-site .visually-hidden')) {
        setTimeout(() => {
            $('.message-site').fadeOut('slow');
        }, 3000)
    }

    // BACK TO TOP BUTTON
    if (!isTabletOrLess) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 80) {
                $('.scroll-js').fadeIn('slow');
            } else {
                $('.scroll-js').fadeOut('slow');
            }
        });
        $('.scroll-js').on('click', function () {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        })
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

    // SLIDER UNIVERS-SINGLE
    if ($('#univers-single').length) {
        let slider = $(".js-slider-univers > div");
        slider.slick({
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
    }
});
