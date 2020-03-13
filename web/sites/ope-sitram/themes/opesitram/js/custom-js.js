jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

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
});