// TEST MOBILE / TAB
var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

// MMENU
if (isTabletOrLess) {
    document.addEventListener(
        "DOMContentLoaded", function () {
            new Mmenu("#block-navigationprincipale", {
                "extensions": [
                    "border-full",
                    "position-front",
                    "fullscreen",
                    "position-right"
                ]
            });
        }
    );
}

jQuery(document).ready(function ($) {
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
