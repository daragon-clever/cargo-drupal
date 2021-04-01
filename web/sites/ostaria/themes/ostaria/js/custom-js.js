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

jQuery(document).ready(function ($) {
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
    $('.js-toggle-menu').click(function () {
        if (isNavOpen === false) {
            openNav();
        } else {
            closeNav();
        }
    });

    //// Instagram-feed
    if ($('#instagram-feed').length) {
        const instagramFeedWrapper = $("#instagram-feed");

        const slickInstagramFeed = function () {
            instagramFeedWrapper.slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 990,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerMode: true,
                            centerPadding: '30px'
                        }
                    }
                ]
            });
        };

        $.instagramFeed({
            'username': 'ostariahomedesign',
            'get_data': true,
            'callback': function(data){
                let dataItem = data.edge_owner_to_timeline_media.edges;

                for (let i = 0; i < dataItem.length && i < 8; i++) {
                    instagramFeedWrapper.append('' +
                        '<div>' +
                            '<a href="https://www.instagram.com/p/' + dataItem[i].node.shortcode + '" target="_blank">' +
                                '<img src="' + dataItem[i].node.thumbnail_src + '">' +
                                '<div class="inner-infos d-flex">' +
                                    '<div>' +
                                        '<div class="likes">' +
                                            dataItem[i].node.edge_liked_by.count +
                                        '</div>' +
                                        '<div class="comments">' +
                                            dataItem[i].node.edge_media_to_comment.count +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</a>' +
                        '</div>');
                }

                $(".loading").hide();
                slickInstagramFeed();
            }
        });
    }

    //// Masonry Custom
    if ($('#inspirations-grid').length) {
        /* Fonctionnement lien HD */
        $('.paragraph > div:first-child').addClass('d-none link-hd');
        $('.paragraph > div:last-child').addClass('thumb');
        $(".link-hd").each(function () {
            var linkHD = $(this).html();
            $(this).next().children("a").attr("href", linkHD);
        });

        $(".thumb a").attr({"data-toggle": "lightbox", "data-gallery": "gallery"});

        /* Ekkolightbox */
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
            $(".ekko-lightbox .modal-body").append("<button type=\"button\" class=\"close\" data-dismiss=\"modal\" " +
                "aria-label=\"Close\"><span aria-hidden=\"true\">✖</span></button>");
        });

        /* Blocs texte */
        var txtBlock = $("#txt-template").html();
        $(txtBlock).insertAfter(".item:not(.text):nth-child(1)");
        $(txtBlock).insertAfter(".item:not(.text):nth-child(11)");
        $(txtBlock).insertAfter(".item:not(.text):nth-child(17)");
        $(txtBlock).insertAfter(".item:not(.text):nth-child(25)");
        /* Ajout des différents style pour bloc texte */
        $(function () {
            $(".item.text").each(function (i) {
                $(this).addClass("style-" + i);
            });
        });

        /* Add class if width > 290 */
        $(".item img").each(function () {
            var width = $(this).attr('width');
            if (width > 290) {
                $(this).closest('.item').addClass('big');
            }
        });

        /* Float right big right ones */
        $(function () {
            $(".item.big").each(function (i) {
                if (i % 2 == 1) {
                    $(this).addClass("js-float-right");
                }
            });
        });

        /* Function shuffle */
        (function (d) {
            d.fn.shuffle = function (c) {
                c = [];
                return this.each(function () {
                    c.push(d(this).clone(true))
                }).each(function (a, b) {
                    d(b).replaceWith(c[a = Math.floor(Math.random() * c.length)]);
                    c.splice(a, 1)
                })
            };
            d.shuffle = function (a) {
                return d(a).shuffle()
            }
        })(jQuery);
        // First, shuffle all except text and big one
        $('.item:not(.text):not(.big) .paragraph').shuffle();
        // Then the big ones
        $('.item.big .paragraph').shuffle();
    }

    //// Scroll homepage
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.js-scroll, .header-rs').fadeOut('slow');
        } else {
            $('.js-scroll, .header-rs').fadeIn('slow');
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

    // FORMS LP MKT
    if ($('.webform-submission-form').length) {
        // Required
        $(".required").parent().addClass("required-wrapper");
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