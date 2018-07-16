jQuery(document).ready(function($) {
    /** Navigation **/
    /* Functions */
    var openNav = function () {
        $('.overlay').fadeToggle();
        $('.navigation').toggleClass('opened');
        $('.nav-inner').fadeIn();
        $('.nav-inner').toggleClass('in-left-menu');
        $('.menu-link ').toggleClass('active');
        $('.button-wrapper').toggleClass('is-active');
        isNavOpen = true;
    };
    var closeNav = function () {
        $('.overlay').fadeToggle();
        $('.navigation').toggleClass('opened');
        $('.nav-inner').toggleClass('in-left-menu');
        $('.nav-inner').fadeOut();
        $('.menu-link').toggleClass('active');
        $('.button-wrapper').toggleClass('is-active');
        isNavOpen = false;
    };

    /* Actions */
    var isNavOpen = false;
    $('.js-toggle-menu').click(function() {
        if (isNavOpen === false) {
            openNav();
        } else {
            closeNav();
        }
    });
});

(function ($, window, document, undefined) {
    'use strict';
    var animationObject;

    function nvsAddAnimation() {
        animationObject.each(function (index, element) {
            var $currentElement = $(element),
                animationType = $currentElement.attr('nvs-animation-type');

            if (nvsOnScreen($currentElement)) {
                $currentElement.addClass('animated ' + animationType);
            }
        });
    }

    // takes jQuery(element) a.k.a. $('element')
    function nvsOnScreen(element) {
        // window bottom edge
        var windowBottomEdge = $(window).scrollTop() + $(window).height();

        // element top edge
        var elementTopEdge = element.offset().top;
        var offset = 100;

        // if element is between window's top and bottom edges
        return elementTopEdge + offset <= windowBottomEdge;
    }

    $(window).on('load', function () {
        animationObject = $('[nvs-animation-type]');
        nvsAddAnimation();
    });

    $(window).on('scroll', function (e) {
        nvsAddAnimation();
    });
}(jQuery, window, document));