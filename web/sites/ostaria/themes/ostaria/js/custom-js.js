jQuery(document).ready(function($) {
    /**** DEBUT - Gestion menu déroulant ****/
    if ($(window).width() <= 1024) {
        $('#block-turbocar-main-menu').addClass('js-mobile');
    }
    /* Hover - Desktop */
    $('#block-turbocar-main-menu:not(.js-mobile) .dd').hover(function () {
        $(this).find('.dd-menu').toggle();
    });
    /* Click - Mobile */
    $('.js-mobile .dd > a').click(function (e) {
        e.stopPropagation();
        var ddMenu = $(this).next('.dd-menu');

        if ($(ddMenu).hasClass('open')) {
            $(this).toggleClass('js-opened');
            $(ddMenu).removeClass('open').slideUp()
        }
        else {
            $(this).toggleClass('js-opened');
            $(ddMenu).addClass('open').slideDown();
        }
    });
    /* Affichage btn deco mobile */
    $('#block-turbocar-main-menu button.navbar-toggler').click(function () {
        $('#block-turbocar-main-menu a.deco').toggle();
    });
    /**** FIN - Gestion menu déroulant ****/

    /* Gestion lien active menu */
    var pathname = window.location.pathname;
    pathname = pathname[0] == '/' ? pathname.substr(1) : pathname;
    if (pathname) {
        $('#block-turbocar-main-menu li a.' + pathname).addClass('active');
    }
});