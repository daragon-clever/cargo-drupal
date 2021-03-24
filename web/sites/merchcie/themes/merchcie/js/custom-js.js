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

    // UI KIT
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

    // HOMEPAGE
    if ($("#homepage").length) {
        // Main ban video
        var video = $("#js-video"),
            videoDuration = video.get(0).duration,
            minutes = parseInt(videoDuration / 60, 10),
            seconds = (videoDuration % 60).toFixed(0);

        $("#js-video-time").html(" | " + minutes + ":" + seconds);

        $('#js-video-btn').click(function () {
            video.fadeToggle();
            $(this).hasClass("playing") ? video.get(0).pause() : video.get(0).play();
            $(this).toggleClass("playing");
        });

        // JS number animation
        Number.prototype.format = function(n) {
            var r = new RegExp('\\d(?=(\\d{3})+' + (n > 0 ? '\\.' : '$') + ')', 'g');
            return this.toFixed(Math.max(0, Math.floor(n))).replace(r, '$&,');
        };

        $('.text-num').each(function () {
            $(this).prop('counter', 0).animate({
                counter: $(this).text()
            }, {
                duration: 10000,
                // easing: 'easeOutExpo',
                step: function (step) {
                    $(this).text('' + step.format());
                }
            });
        });
    }

    // TESTIMONIALS
    $(".js-testimonials-slick").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        // autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 990,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});