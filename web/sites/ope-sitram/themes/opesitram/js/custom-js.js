jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // SLICK
    var gammesSlider = $(".js-gammes-slick");
    var productsSlider = $(".js-slick-products");
    var instagramSlider = $(".js-insta-slick");

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

        instagramSlider.slick({
            infinite: true,
            dots: false,
            adaptiveHeight: true,
            prevArrow: $('.js-prev-slick'),
            nextArrow: $('.js-next-slick')
        });
    }

    // HAMBURGER
    $(".hamburger").on("click", function () {
        $(this).toggleClass("active");
        $("#menu").fadeToggle();
    });

    // SMOOTH SCROLL
    $(function() {
        // ON LOAD
        function smoothScrollTo(target) {
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1500);
            }
        }
        if (location.hash) {
            window.scrollTo(0, 0);
            target = location.hash.split('#');
            smoothScrollTo($('#'+target[1]));
        }

        // ON CLICK
        $("a[href*='#']:not([href='#']):not('.navbar-toggler')").click(function() {
            if (
                location.hostname == this.hostname
                && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
            ) {
                var anchor = $(this.hash);
                anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
                if ( anchor.length ) {
                    $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
                }
            }
        });
    });

    // GESTION LIEN STORELOCATOR
    var storeLocatorLink = $("#block-navigationprincipale .storelocator-main-link");
    if ( window.location.pathname == '/' ){
        storeLocatorLink
            .attr("href", "#js-store-locator")
            .removeClass("is-active");
    } else {
        storeLocatorLink.attr("href", "accueil#js-store-locator");
    }

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
            'items': 4,
            'items_per_row': 4,
            'margin': 1,
            'lazy_load': true,
            'on_error': function () {
                $('#js-instagram').html('<a href="https://www.instagram.com/sitram_fr" target="_blank"><img class="mw-100" src="/sites/ope-sitram/themes/opesitram/images/footer/fake-insta.png" /></a>')
            }
        });
    })();
});