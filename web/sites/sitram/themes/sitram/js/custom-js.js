jQuery(document).ready(function ($) {
    // NAV REPONSIVE
    $('.js-resp-menu').click(function () {
        $("header .nav-wrapper, .js-resp-menu, .header-wrapper + .content").toggleClass('active');
        const n1_Link = $('#block-sitram-main-menu > ul > li > a');

        n1_Link.click(function (e) {
            const allSubMenu = $(n1_Link).next('ul');
            const subMenu = $(this).next('ul');

            if (subMenu.length > 0) {
                e.preventDefault();
                allSubMenu.slideUp();
                subMenu.slideToggle();
            }
        })
    });


    // CAROUSEL USTENSILES (page recettes)
    if ($('#recette-individuelle').length) {
        $('.js-ustensiles-slider > div').slick();
    }

    // HOMEPAGE
    if ($('#homepage').length) {
        // CAROUSEL HOMEPAGE
        const observer = lozad();
        observer.observe();

        $('.js-homepage-slider > div').slick({
            dots: true
        });

        // INSTAGRAM
        (function () {
            new InstagramFeed({
                'username': 'sitram_fr',
                'container': document.getElementById("js-instagram"),
                'display_profile': false,
                'display_biography': false,
                'display_gallery': true,
                'display_captions': false,
                'callback': null,
                'styling': true,
                'items': 6,
                'items_per_row': 3,
                'margin': 1,
                'lazy_load': true,
                'on_error': function () {
                    $('#js-instagram').html('<img class="mw-100" src="/sites/sitram/themes/sitram/images/fake-insta-hp.png" />')
                }
            });
        })();
    }

    // MASONRY GALLERY
    if ($(".js-grid-masonry").length) {
        const $grid = $('.js-grid-masonry').imagesLoaded(function () {
            $grid.masonry({
                itemSelector: '.grid-item',
                columnWidth: '.grid-sizer',
                percentPosition: true
            });
        });
    }

    // PRODUITS
    if ($('.js-colored-slideshow').length) {
        $('.js-colored-slideshow').slick({
            fade: true,
            arrows: true
        })
    }

    if ($('.js-slick-txt').length) {
        $('.js-slick-txt').slick({
            slidesToShow: 4,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 567,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true
                    }
                }
            ]
        })
    }

    // RECETTES

    // Ne pas suppr, peut servir pour afficher un badge avec le nombre de filtres selectionnés
    // Ne fonctionne pas a cause d'AJAX, à creuser
    if ($(".recettes-filters").length) {
        /*let updateFilterCount = function (inputsWrapper) {
            let filtersCount = inputsWrapper.find('input:checked').length;
            let legend = inputsWrapper.prev();
            let counter = legend.find('.js-filter-count');

            if (counter.length) {
                counter.html(filtersCount)
            } else {
                legend.append('<span class="js-filter-count">' + filtersCount + '</span>')
            }
        };*/

        $(document).on('click', 'fieldset legend', function () {
            $(this).next().slideToggle();
            /*updateFilterCount($(this).next());*/
        })
    }

    // POPUP VIDEO
    $('.js-open-video').click(function (e) {
        e.preventDefault();
        $(this).next('.js-hidden-video').fadeIn();
    });

    $('.js-close-hidden-video').click(function () {
        const iframe = $(this).prev();
        const src = iframe.attr('src');
        $(this).parents('.js-hidden-video').fadeOut();
        iframe.attr('src', '');
        iframe.attr('src', src)
    });

    // FOOTER
    $(".js-show-hidden-part").click(function (e) {
        if (!$(this).hasClass('opened')) {
            e.preventDefault();
            $(".js-hidden-part").addClass('show');
            $(this).addClass('opened');
        }
    });

    // COMMUNAUTE
    if ($('#js-instagram-commu').length) {
        // INSTAGRAM
        (function () {
            new InstagramFeed({
                'username': 'sitram_fr',
                'container': document.getElementById("js-instagram-commu"),
                'display_profile': false,
                'display_biography': false,
                'display_gallery': true,
                'display_captions': false,
                'callback': null,
                'styling': true,
                'items': 12,
                'items_per_row': 3,
                'margin': 1,
                'lazy_load': true,
                'on_error': function () {
                    $('#js-instagram-commu').html('<img class="mw-100" src="/sites/sitram/themes/sitram/images/fake-insta-commu.png" />')
                }
            });
        })();
    }
});

