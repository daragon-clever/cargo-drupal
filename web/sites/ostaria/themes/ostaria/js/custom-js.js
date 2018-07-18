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

// Animations - Récup des attr sur elements
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

// Instafeed
var userFeed = new Instafeed({
    get: 'user',
    userId: '8227460958',
    accessToken: '8227460958.1677ed0.9042fc03b313415b804d04d205e6bc7c',
    limit: 8,
    resolution: 'standard_resolution',
    after: function () {
        jQuery('#instafeed').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4
        });
    },
    template:
    '<div>' +
        '<a href="{{link}}" id="{{id}}" target="_blank"><img class="img-fluid" src="{{image}}" />' +
        '<span class="overlay-wrapper"><span>' +
            '<span class="likes">{{likes}}</span>' +
            '<span class="comments">{{comments}}</span>' +
        '</span></span></a>' +
    '</div>'
});
userFeed.run();