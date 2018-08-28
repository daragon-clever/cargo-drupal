jQuery(document).ready(function($) {
    // SLICK
    if ($(".mea-marques").length) {
        $(".mea-marques").slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5
                    }
                },
                {
                    breakpoint: 991,
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
                        arrows:false,
                        centerMode: true
                    }
                }
            ]
        });
    }

    // FONCTIONNEMENT GALERIE METIER
    if ($(".page-presentation-groupe").length) {
        // Galerie
        $(".portrait").hover( function() {
            $(this).children(".bulle").show();
        });
        $(".portrait").on("mouseleave", function() {
            $(".bulle").hide();
        });
        $(".bulle").on("click", function() {
            $(this).hide();
        });
        $(".big-portrait .portrait").on("click", function() {
            var portraitIndex = $(this).index();
            $(".portrait-infos").show();
            $(".thumb img").removeClass("current");
            $(".txt > div > div").removeClass("current");
            $(".thumb img").eq(portraitIndex).addClass("current");
            $(".txt > div > div").eq(portraitIndex).addClass("current");
        });

        // Infos
        $(".thumb img").eq(0).addClass("current");
        $(".txt > div > div").eq(0).addClass("current");
        $(".portrait-infos .thumb img").on("click",function() {
            var thumbIndex = $(this).index();
            $(".portrait-infos .thumb img").removeClass("current");
            $(this).addClass("current");
            $(".txt > div > div").removeClass("current");
            $(".txt > div > div").eq(thumbIndex).addClass("current");
        });
    }

    // LOADER AJAX
    if (typeof(Drupal) != "undefined") {
        Drupal.Ajax.prototype.setProgressIndicatorFullscreen = function () {
            this.progress.element = $('' +
                '<div class="loader">' +
                '<div id="status"><div class="spinner"> </div> </div>' +
                '</div>');
            $('.vue-evenement, .vue-presse').append(this.progress.element);
        };
    }

    // FOOTER FIXED SI BODY COURT
    var body = $(document.body).height();
    var windowHeight = $(window).height();
    if (body < windowHeight) {
        $('#block-menufooter').addClass('fixed');
    }

    // DROPUP FOOTER : MOBILE
    $("a.dropup").on("click", function (e) {
        e.preventDefault();
    });
});