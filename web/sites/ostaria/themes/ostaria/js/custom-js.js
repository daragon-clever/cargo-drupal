jQuery(document).ready(function($) {
    /* Test Navigation */
    var openNav = function () {
        $('.overlay').fadeToggle();
        $('.navigation').toggleClass('opened');
        $('.nav-inner').fadeIn();
        $('.nav-inner').toggleClass('in-left');
        $('.menu-link ').toggleClass('active');
        $('.button-wrapper').toggleClass('is-active');
        isNavOpen = true;
    };
    var closeNav = function () {
        $('.overlay').fadeToggle();
        $('.navigation').toggleClass('opened');
        $('.nav-inner').toggleClass('in-left');
        $('.nav-inner').fadeOut();
        $('.menu-link').toggleClass('active');
        $('.button-wrapper').toggleClass('is-active');
        isNavOpen = false;
    };

    var isNavOpen = false;

    $('.js-toggle-menu').click(function() {
        if (isNavOpen === false) {
            openNav();
        } else {
            closeNav();
        }
    });
});