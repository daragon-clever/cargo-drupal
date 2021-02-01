//MMENU
let isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;
if (isTabletOrLess) {
    document.addEventListener(
        "DOMContentLoaded", function () {
            new Mmenu("#block-cestdeuxeuros-main-menu", {
                "autoHeight": true,
                "extensions": [
                    "theme-white",
                    "border-full",
                    "position-front",
                    "pagedim-black",
                    "position-top"
                ]
            });
        }
    );
}


jQuery(document).ready(function ($) {
    // FORMULAIRE DE CONTACT
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
    }

    // Bind click HP
    $("#homepage-content .right a").click(function (e) {
        e.preventDefault();
        $("footer a[data-target='#modal-newsletter']").click();
    });

    // HEADER - SCROLL
    if (!isTabletOrLess) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('.header-wrapper').addClass('header-scroll')
            } else {
                $('.header-wrapper').removeClass('header-scroll')
            }
        });
    }
});