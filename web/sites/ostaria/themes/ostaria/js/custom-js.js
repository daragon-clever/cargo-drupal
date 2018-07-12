jQuery(document).ready(function($) {
    /* Test */
    $('.toggle-menu').click(function() {
        $('.overlay').fadeToggle();
        $('.navigation').toggleClass('opened');
        $('.nav-inner').toggleClass('in-left');
        $(this).toggleClass('active');
    });
});