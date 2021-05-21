jQuery(document).ready(function($) {
    // TEST MOBILE
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

    // NEW HP SLIDER
    $(".js-slider-4-elements").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
    });

    // JOIN US
    if ($('.joinus-portraits').length) {
        var thumbItem = $('.thumbs .item');
        thumbItem.on('click', function () {
            var thumbItemId = $(this).attr('id');
            var txtActiveId = "#text-" + thumbItemId;

            if (!isMobile) {
                // DESKTOP + TAB
                var itemTxt = $(".itw-content .item");

                itemTxt.hide();
                $(txtActiveId).css("display","flex");
            } else {
                // MOBILE
                var itemTxt = $(".thumbs .txt");

                $("#js-anchor").removeAttr("id");
                itemTxt.hide();
                $(txtActiveId).css("display","block");
                $('.thumbs .item').removeClass('active');
                $(this).addClass('active');

                if ($(this).hasClass('odd')) {
                    $(txtActiveId).insertAfter(this);
                } else {
                    $(txtActiveId).insertAfter($(this).next());
                }
            }
        })
    }

    // FORMS
    if ($('.webform-submission-form').length) {
        // Required
        $(".required").parent().addClass("required-wrapper");
    }

    // SCROLL FOOTER LOGO
    function scrollMove( ele ,frame ,step ) {
        var step = step || 1;
        var $item = $(ele).children();
        var w = 0 ;
        $item.each(function () {
            w += $(this).outerWidth();
        });

        $(ele).html( $(ele).html() + $(ele).html() );

        var $items = $(ele);
        var temp = 0;
        function move() {
            if ( temp > w ){
                temp = 0
            } else {
                temp = temp + step ;
            }
            $items.scrollLeft( temp );
        }
        setInterval(move , 2000 / frame);
    }

    if (isMobile) {
        scrollMove('.c-footer__logos-wrapper', 60 , 1 );
    }
});