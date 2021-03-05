jQuery(document).ready(function ($) {
    // TEST MOBILE / TAB
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // SLICK
    var gammesSlider = $(".js-gammes-slick");
    var productsSlider = $(".js-slick-products");

    gammesSlider.slick({
        infinite: true,
        dots: true,
        adaptiveHeight: true
    });

    if (isTabletOrLess) {
        productsSlider.slick({
            infinite: true,
            dots: true,
            adaptiveHeight: true
        });
    }

    // HAMBURGER
    $(".hamburger").on("click", function () {
        $(this).toggleClass("active");
        $("#menu").fadeToggle();
    });

    // SMOOTH SCROLL
    $(function () {
        // ON LOAD
        function smoothScrollTo(target) {
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1500);
            }
        }

        if (location.hash) {
            window.scrollTo(0, 0);
            target = location.hash.split('#');
            smoothScrollTo($('#' + target[1]));
        }

        // ON CLICK
        $("a[href*='#']:not([href='#']):not('.navbar-toggler')").click(function () {
            if (
                location.hostname == this.hostname
                && this.pathname.replace(/^\//, "") == location.pathname.replace(/^\//, "")
            ) {
                var anchor = $(this.hash);
                anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) + "]");
                if (anchor.length) {
                    $("html, body").animate({scrollTop: anchor.offset().top}, 1500);
                }
            }
        });
    });

    // GESTION LIEN STORELOCATOR
    var storeLocatorLink = $("#block-navigationprincipale .storelocator-main-link");
    if (window.location.pathname == '/') {
        storeLocatorLink
            .attr("href", "#js-store-locator")
            .removeClass("is-active");
    } else {
        storeLocatorLink.attr("href", "accueil#js-store-locator");
    }

    // INSTAGRAM + SLICK
    if ($('#js-instagram').length) {
        const instaSlick = function () {
            $("#js-instagram").slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                dots: false,
                mobileFirst:true,
                responsive: [
                    {
                        breakpoint: 990,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
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
        }

        $(function () {
            new InstagramFeed({
                'username': 'sitram_fr',
                'display_profile': false,
                'display_biography': false,
                'display_gallery': true,
                'display_captions': false,
                'callback': function (data) {
                    let dataItem = data.edge_owner_to_timeline_media.edges;
                    for (let i = 0; i < dataItem.length && i < 8; i++) {
                        $("#js-instagram").append(`
                            <div>
                                <a href="${'https://www.instagram.com/p/' + dataItem[i].node.shortcode + '/'}" target="_blank">
                                    <img src="${dataItem[i].node.thumbnail_src}" />
                                </a>
                            </div>
                        `);
                    }
                    instaSlick();
                },
                'styling': true,
                'lazy_load': true,
                'on_error': function () {
                    $('#js-instagram').html('<a href="https://www.instagram.com/sitram_fr" target="_blank"><img class="mw-100" src="/sites/ope-sitram/themes/opesitram/images/footer/fake-insta.png" /></a>')
                }
            });
        })();
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
});