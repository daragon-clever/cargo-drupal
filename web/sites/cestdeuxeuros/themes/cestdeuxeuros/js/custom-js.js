jQuery(document).ready(function($) {
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
    $("#homepage-content .right a").click(function(e) {
        e.preventDefault();
        $("footer a[data-target='#modal-newsletter']").click();
    });

    // MENU Mobile
    $('.btn-menu-mobile i').each( function() {
        $(this).click(function() {
            $('.btn-menu-mobile i').toggle();
            $('.menu').toggleClass('active');
            $('.main-content').toggleClass('blur');
        });
    })
});