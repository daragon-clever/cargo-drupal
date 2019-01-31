jQuery(document).ready(function($) {
    // MENU
    if ($(window).width() <= 991) {
        $('.main-menu').addClass('js-mobile');
    }
    // Hover - Desktop
    $('.main-menu:not(.js-mobile) li').hover(function () {
        $(this).find('ul').fadeToggle("fast");
    });
    // Click - Mobile
    $('.js-mobile li').click(function (e) {
        e.stopPropagation();
        var ddMenu = $(this).find("ul");

        if ($(ddMenu).hasClass('open')) {
            $(this).toggleClass('js-opened');
            $(ddMenu).removeClass('open').slideUp()
        }
        else {
            $(this).toggleClass('js-opened');
            $(ddMenu).addClass('open').slideDown();
        }
    });

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
                        slidesToScroll: 3,
                        arrows:false,
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

        // Fleches nav
        $(".arrows-nav > .prev").on("click", function () {
            var currentPortrait = $(".portrait-infos .thumb img.current");
            var prevPortraitIndex = currentPortrait.prev().index();

            var prevPortrait = function() {
                $(".portrait-infos .thumb img").removeClass("current");
                $(".txt > div > div").removeClass("current");
                $(".txt > div > div").eq(prevPortraitIndex).addClass("current");
                $(".portrait-infos .thumb img").eq(prevPortraitIndex).addClass("current");
            };

            prevPortrait();
        });
        $(".arrows-nav > .next").on("click", function () {
            var currentPortrait = $(".portrait-infos .thumb img.current");
            var nextPortraitIndex = currentPortrait.next().index();

            var nextPortrait = function() {
                $(".portrait-infos .thumb img").removeClass("current");
                $(".txt > div > div").removeClass("current");
                console.log(nextPortraitIndex);
                if (nextPortraitIndex === -1) {
                    // Si on est au dernier, remettre le 1er
                    $(".txt > div > div").eq(0).addClass("current");
                    $(".portrait-infos .thumb img").eq(0).addClass("current");
                } else {
                    $(".txt > div > div").eq(nextPortraitIndex).addClass("current");
                    $(".portrait-infos .thumb img").eq(nextPortraitIndex).addClass("current");
                }
            };

            nextPortrait();
        });
    }

    // LOADER AJAX
    if (typeof(Drupal) != "undefined") {
        if (typeof(Drupal.Ajax) != "undefined") {
            Drupal.Ajax.prototype.setProgressIndicatorFullscreen = function () {
                this.progress.element = $('' +
                    '<div class="loader">' +
                    '<div id="status"><div class="spinner"> </div> </div>' +
                    '</div>');
                $('.vue-evenement, .vue-presse').append(this.progress.element);
            };
        }
    }

    // DROPUP FOOTER : MOBILE
    $("a.dropup, a.dropdown").on("click", function (e) {
        e.preventDefault();
    });

    // SOUSMENU POUR FOOTER MOBILE
    if ($(window).width() <= 575) {
        var dropUpLink = $("a.dropup");
        $(dropUpLink).next("ul").hide();
        $(dropUpLink).on("click", function () {
            $(this).toggleClass("js-opened");
            $(this).next("ul").slideToggle();
        })
    }

    // FORMULAIRES
    if ($('.webform-submission-form').length) {
        $('input, textarea').blur(function () {
            tmpval = $(this).val();
            if (tmpval == '') {
                $(this).addClass('js-empty');
                $(this).removeClass('js-not-empty');
            } else {
                $(this).addClass('js-not-empty');
                $(this).removeClass('js-empty');
            }
        });
    }

    // BLACK AND WHITE FOR IE11
    if($(".mea-marques").length) {
        $('.mea-marques .bottom > div').BlackAndWhite({
            hoverEffect : true
        });
    }
});