jQuery(document).ready(function($) {
    // TEST MOBILE
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

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
});