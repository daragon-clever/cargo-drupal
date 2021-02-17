let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
let isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

//MMENU
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


    if ($('#newsletterform-wrapper').length) {
        $('#edit-rgpd-allow').after(
            "<span class='custom-checkbox'>" +
            "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' aria-hidden='true' focusable='false'>" +
            "        <path fill='none' stroke='currentColor' stroke-width='3' d='M1.73 12.91l6.37 6.37L22.79 4.59' /></svg>" +
            "</span>"
        );
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

    // ASTUCES
    if ($(".astuce-block").length) {
        const block = $(".astuce-block");

        block.on("click", function (e) {
            const dataContent = $(this).attr("data-content");
            const currentText = $(".content-wrapper[data-content=" + dataContent + "]");
            const textes = $(".content-wrapper");

            e.preventDefault();
            block.children("a").removeClass("current");
            $(this).children("a").addClass("current");
            textes.hide();

            if (isTabletOrLess) {
                currentText.addClass("col-12");
                if ($(this).hasClass('odd')) {
                    $(currentText).insertAfter($(this).parent());
                } else {
                    $(currentText).insertAfter($(this).parent().next());
                }
            }

            currentText.show();
        });
    }
});