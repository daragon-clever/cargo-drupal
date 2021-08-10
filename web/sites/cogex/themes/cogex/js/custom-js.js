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

    // EASIER READ MORE/LESS
    $( "button#js-more-less" ).click(function() {
        let $this = $(this);
        $this.prev().slideToggle( "fast" );
        $this.toggleClass("open");

        if ($this.hasClass("open")) {
            $this.html("Fermer");
        } else {
            $this.html("Lire plus");
        }
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

    scrollMove('.c-footer__logos-wrapper', 60 , 1 );

    /*** Recherche PDF ***/
    if ($("#page-espace-conso").length) {
        //add style
        $('#select-container select').select2();
        $('form input[type=submit]').addClass('c-button c-button--primary');

        var cookieName = "pdfsearch-choice-usr";
        var selectId = "#select-form-display";
        var searchFormContainerClass = ".search-form-item";

        $(searchFormContainerClass).hide();

        $(selectId).change(function() {
            var selectedOption = $(this).val();
            $(searchFormContainerClass).hide(); //hide form display
            if ($('#'+selectedOption).length != 0) $('#'+selectedOption).show(); //display if form container exist

            Cookies.set(cookieName, selectedOption, { expires : 1 }); //save current select value
        });

        var cookieUsrChoice = Cookies.get(cookieName);
        if (cookieUsrChoice != undefined) $(selectId).val(cookieUsrChoice).trigger('change'); //set select value with cookie (last search)
    }
    /*** Fin recherche PDF ***/
});

function triggerChangeCustom(valueOfSelect)
{
    var selectId = "#select-form-display";
    jQuery(selectId).val(valueOfSelect).trigger('change'); //change value of select

    jQuery('html, body').animate({
        scrollTop: jQuery('#'+valueOfSelect).offset().top //scroll to the form
    }, 1000);
}

