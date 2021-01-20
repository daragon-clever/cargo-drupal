let isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;
if (isTabletOrLess) {
    document.addEventListener(
        "DOMContentLoaded", function () {
            new Mmenu("#block-sitram-main-menu", {
                "extensions": [
                    "theme-white",
                    "border-full",
                    "position-front",
                    "pagedim-black",
                    "position-right"
                ]
            });
        }
    );
}

jQuery(document).ready(function ($) {
    // OBJECT FIT SUPPORT FOR IE11
    $(function () {
        objectFitImages()
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

        if (!isTabletOrLess) {
            const windowWidth = window.innerWidth;
            const ratio = 4.8;
            const minHeightValue = windowWidth <= 1920 ? (windowWidth / ratio) : 400;
            $('.js-homepage-slider').css('min-height', minHeightValue);
        }

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
                    $('#js-instagram').html('<a href="https://www.instagram.com/sitram_fr" target="_blank"><img class="mw-100" src="/sites/sitram/themes/sitram/images/fake-insta-hp.png" /></a>')
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
            $(this).toggleClass("active");
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
    $(".js-show-hidden-part").click(function () {
        if (!$(this).hasClass('opened')) {
            $(".js-hidden-part").addClass('show');
            $(this).addClass('opened');
        }
    });
    (function ($) {
        $.fn.myCustomReloadReCatpcha = function () {
            console.log('on a submit');
            grecaptcha.reset();
        };
    })(jQuery);

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
                    $('#js-instagram-commu').html('<a href="https://www.instagram.com/sitram_fr" target="_blank"><img class="mw-100 fake-img" src="/sites/sitram/themes/sitram/images/fake-insta-commu.jpg" /></a>')
                }
            });
        })();
    }
});

