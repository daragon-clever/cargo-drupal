// TEST MOBILE
let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
let isTablet = window.matchMedia("only screen and (max-width: 990px)").matches;

if (isTablet) {
    document.addEventListener(
        "DOMContentLoaded", () => {
            new Mmenu( "#main-nav", {
                "extensions": [
                    "border-full",
                    "position-front"
                ],
            });
        }
    );
}

jQuery(document).ready(function($) {
    // FORMULAIRE CONTACT
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
        $("input.required + label, textarea.required + label, select.required").after("<span class='required-star'>*</span>");
    }

    // PRESTATIONS BLOCKS TEXTE
    if ($(".service-block").length) {
        const block = $(".domaine-block");

        block.on("click", function(e) {
            const dataContent = $(this).attr("data-content");
            const currentText = $(".txt[data-content=" + dataContent + "]");
            const textes = $(".txt");

            e.preventDefault();
            block.children("a").removeClass("current");
            $(this).children("a").addClass("current");
            textes.hide();

            if (isMobile) {
                currentText.addClass("col-12");
                if ($(this).hasClass('odd')) {
                    $(currentText).insertAfter($(this).parent());
                } else {
                    $(currentText).insertAfter($(this).parent().next());
                }
            }

            currentText.show();
        });

        // Gallery
        $('.js-slick-main').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.js-slick-main-nav',
        });

        // Gallery thumbs
        $('.js-slick-main-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.js-slick-main',
            focusOnSelect: true,
            arrows: true,
            mobileFirst: true,
            centerMode: true,
            centerPadding: 0,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                }
            ]
        });

        // Click btn gallery
        var btnGallery = $(".txts-wrapper > div .cta");

        btnGallery.on("click", function() {
            var dataContent = $(this).parents(".txt").attr("data-content");
            var gallery = $(".js-presta-gallery[data-content=" + dataContent + "]");
            var closeBtn = $(".js-close-gallery");

            gallery.addClass("active");

            closeBtn.on("click", function() {
                gallery.removeClass("active")
            })
        })
    }
});