jQuery(document).ready(function ($) {
    // TEST MOBILE / TAB
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // STICKY HEADER
    $(window).scroll(function(){
        var header = $('header');
        if ($(window).scrollTop() >= 1) {
            header.addClass('fixed');
        } else {
            header.removeClass('fixed');
        }
    });

    /** UI KIT **/
    if ($("#ui-kit").length) {
        document.querySelectorAll("code").forEach(function (element) {
            element.innerHTML = element.innerHTML
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        });
        hljs.highlightAll();
    }
});