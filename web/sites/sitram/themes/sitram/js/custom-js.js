let isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;
if (isTabletOrLess) {
    // Move language switcher
    jQuery(document).ready(function ($) {
        const languageSwitchLink = $("ul.links li:not('.is-active')");
        const mainNav = $("#mm-1 > ul");

        languageSwitchLink.addClass('mm-listitem js-switchLangLink');
        languageSwitchLink.children().addClass('mm-listitem__text');
        languageSwitchLink.appendTo(mainNav);
    });

    // MMenu
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

hash = document.location.hash;
if (hash != "") {
    setTimeout(function () {
        if (location.hash) {
            window.scrollTo(0, 0);
            window.location.href = hash;
        }
    }, 1);
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

    // Ne pas suppr, peut servir pour afficher un badge avec le nombre de filtres selectionn??s
    // Ne fonctionne pas a cause d'AJAX, ?? creuser
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

    // IMPRESSION
    $('.js-print').click(function () {
        $('.header-section img, h1, .js-prepa, .js-recette, .js-ingredients').printThis();
    });

    // PARTAGE RESEAUX
    $('.js-partager, .js-close').click(function () {
        $('.popup').toggleClass('open');
    })

    // URL PAGE RECETTE
    if ($('#recette-individuelle').length) {
        let input = $('#js-copy-input');
        input.val(window.location.href);
        $('#js-copy-button').click(function () {
            input.select();
            input[0].setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
            $('.js-copy-confirm').toggleClass('show');
            setTimeout(function () {
                $('.js-copy-confirm').removeClass('show')
            }, 3000);
        });
    }

    // FACEBOOK-MESSENGER
    $('.js-messenger').click(function () {
        let link = window.location.href;
        window.open('fb-messenger://share?link=' + encodeURIComponent(link));
    })

    // SEARCHBAR - OP
    if ($('#op-commerciale').length) {

        // Afficher les d??partements tri??s sous la forme de <li>
        let lines = $('.js-departments').text().split('\n');
        let departments = [];
        $.each(lines, function (key, value) {
            let cleanValue = value.trim();
            if (cleanValue.length > 0) {
                departments.push(cleanValue);
            }
        })
        departments.sort();
        $.each(departments, function (key, value) {
            $('.js-departments-result').append('<li>' + value + '</li>');
        })

        // Autoriser seulement la saisie de chiffres
        $('#userInput').keypress(function (event) {
            let char = String.fromCharCode(event.which);
            if (!(/[0-9]/.test(char))) {
                event.preventDefault();
            }
        });

        // Filtrer les r??sultats
        $('#userInput').keyup(function () {
            let input = $(this).val();
            let li = $(".js-departments-result>li");
            for (let i = 0; i < li.length; i++) {
                let value = li[i].textContent.slice(0,2);
                if (value.indexOf(input) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        })
    }
});
