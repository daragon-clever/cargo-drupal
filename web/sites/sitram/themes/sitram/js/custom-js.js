jQuery(document).ready(function ($) {
    // CAROUSEL HOMEPAGE
    $('.js-homepage-slider > div').slick({
        dots: true
    });

    // INSTAGRAM
    (function () {
        new InstagramFeed({
            'username': 'sitram_fr',
            'container': document.getElementById("js-instagram"),
            'display_profile': false,
            'display_biography': false,
            'display_gallery': true,
            'display_captions': false,
            'callback': null,
            'styling': true,
            'items': 8,
            'items_per_row': 4,
            'margin': 1,
            'lazy_load': true,
            'on_error': console.error
        });
    })();

    // MASONRY GALLERY
    if ($("#sitram-et-moi").length) {
        $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true
        });
    }

    // FOOTER
    $(".js-show-hidden-part").click(function(e) {
        if (!$(this).hasClass('opened')) {
            e.preventDefault();
            $(".js-hidden-part").addClass('show');
            $(this).addClass('opened');
        }
    });

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
});

