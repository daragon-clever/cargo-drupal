jQuery(document).ready(function($) {
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

    if (typeof(Drupal) != "undefined") {
        Drupal.Ajax.prototype.setProgressIndicatorFullscreen = function () {
            this.progress.element = $('' +
                '<div class="loader">' +
                '<div id="status"><div class="spinner"> </div> </div>' +
                '</div>');
            $('.vue-evenement').append(this.progress.element);
        };
    }
});