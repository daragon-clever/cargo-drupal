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
    })

    // SMOOTH SCROLL
    $("a").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash;
            });
        }
    });
});