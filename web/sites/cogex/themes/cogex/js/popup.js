jQuery(document).ready(function($) {
    if ($('.popup').length) {
        $('.popup-toggle').on('click', function(e) {
            e.preventDefault();
            $('.popup').toggleClass('is-visible');
        });
    }
});
