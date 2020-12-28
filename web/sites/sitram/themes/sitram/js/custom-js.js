jQuery(document).ready(function ($) {
    // CAROUSEL HOMEPAGE
    $('.js-homepage-slider > div').slick({
        dots: true
    });

    // CAROUSEL USTENSILES (page recettes)
    $('.js-ustensiles-slider > div').slick();

    // INSTAGRAM
    if ($('#homepage').length) {
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
                'on_error': console.error
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


    // FOOTER
    $(".js-show-hidden-part").click(function (e) {
        if (!$(this).hasClass('opened')) {
            e.preventDefault();
            $(".js-hidden-part").addClass('show');
            $(this).addClass('opened');
        }
    });

    // FORMULAIRE CONTACT
    if ($('.webform-submission-form').length) {
        // Function
        var checkValue = function (e) {
            tmpval = e.val();
            if (tmpval === '') {
                e.addClass('js-empty').removeClass('js-not-empty');
            } else {
                e.addClass('js-not-empty').removeClass('js-empty');
            }
        };
        // Var Elts
        var formElts = $('input, textarea');
        // 1er chargement
        formElts.each(function () {
            checkValue($(this));
        });
        // Au clic sur l'elt
        formElts.blur(function () {
            checkValue($(this));
        });
        $("input.required + label, textarea.required + label, select.required").after("<span class='required-star'>*</span>");
    }
});

