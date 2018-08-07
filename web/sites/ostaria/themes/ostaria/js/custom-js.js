jQuery(document).ready(function($) {
    //// Navigation
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

    //// Instafeed
    if ($('#instafeed').length) {
        var userFeed = new Instafeed({
            get: 'user',
            userId: '8227460958',
            accessToken: '8227460958.1677ed0.9042fc03b313415b804d04d205e6bc7c',
            limit: 8,
            resolution: 'standard_resolution',
            // Slick
            after: function () {
                $('#instafeed').slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows:false,
                                centerMode: true
                            }
                        }
                    ]
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
    }

    //// Masonry Custom
    if ($('#inspirations-grid').length) {
        /* Blocs texte */
        var txtBlock = $("#txt-template").html();
        $( txtBlock ).insertAfter(".item:not(.text):nth-child(1)");
        $( txtBlock ).insertAfter(".item:not(.text):nth-child(11)");
        $( txtBlock ).insertAfter(".item:not(.text):nth-child(17)");
        $( txtBlock ).insertAfter(".item:not(.text):nth-child(25)");
        /* Ajout des différents style pour bloc texte */
        $(function(){
            $(".item.text").each(function(i){
                $(this).addClass("style-" + i);
            });
        });

        /* Add class if width > 290 */
        $(".item > img").each(function () {
            var width = $(this).attr('width');
            if (width > 290) {
                $(this).parent('.item').addClass('big');
            }
        });

        /* Float right big right ones */
        $(function(){
            $(".item.big").each(function(i){
                if (i % 2 == 1) {
                    $(this).addClass("js-float-right");
                }
            });
        });

        /* Function shuffle */
        (function(d){d.fn.shuffle=function(c){c=[];return this.each(function(){c.push(d(this).clone(true))}).each(function(a,b){d(b).replaceWith(c[a=Math.floor(Math.random()*c.length)]);c.splice(a,1)})};d.shuffle=function(a){return d(a).shuffle()}})(jQuery);
        // First, shuffle all except text and big one
        $('.item:not(.text):not(.big)').shuffle();
        // Then the big ones
        $('.item.big').shuffle();
    }

    //// Scroll homepage
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('.js-scroll').fadeOut('slow');
        } else {
            $('.js-scroll').fadeIn('slow');
        }
    });

    //// Page Contact
    if ($('.ostaria-contact-form').length) {
        $(document.body).addClass('page-contact');
        $('input, textarea').blur(function () {
            tmpval = $(this).val();
            if (tmpval == '') {
                $(this).addClass('js-empty');
                $(this).removeClass('js-not-empty');
            } else {
                $(this).addClass('js-not-empty');
                $(this).removeClass('js-empty');
            }
        });
    }

    /// Page QSN
    if ($('.qsn').length) {
        $('.js-date').on('click', function () {
            var dateId = $(this).attr('id');
            $('.js-date').removeClass('current');
            $(this).addClass('current');
            $('.js-date-text').removeClass('current');
            $('.js-date-text#txt-' + dateId).addClass('current');
        })
    }
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