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
    // STICKY HEADER
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 1) {
            $('header').addClass('fixed');
            $('body').addClass('header-is-fixed')
        } else {
            $('header').removeClass('fixed');
            $('body').removeClass('header-is-fixed')
        }
    });

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
