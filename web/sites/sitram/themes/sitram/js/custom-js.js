jQuery(document).ready(function($) {
    // CAROUSEL HOMEPAGE
    $('.js-homepage-slider > div').slick({
        dots: true
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
