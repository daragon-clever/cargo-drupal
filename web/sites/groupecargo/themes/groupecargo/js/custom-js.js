jQuery(document).ready(function ($) {
    // TEST MOBILE / TAB
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // NAV
    var timerNav;
    $("#header-wrapper nav").hover(
        function () {
            timerNav = setTimeout(function () {
                $("#header-wrapper").addClass("menu-hover");
            }, 400);
        },
        function () {
            $("#header-wrapper").removeClass("menu-hover");
            clearTimeout(timerNav);
        }
    );

    if (isTabletOrLess) {
        // NAV MOBILE
        var $menu = $("#block-groupecargo-main-menu").mmenu({
            "extensions": [
                "theme-white",
                "border-full",
                "position-front",
                "pagedim-black",
                "fullscreen",
                "position-right"
            ]
        }, {
            clone: true
        });

        var $icon = $(".navbar-toggler");
        var API = $menu.data("mmenu");

        API.bind("open:start", function () {
            setTimeout(function () {
                $icon.addClass("is-active");
                $icon.on("click", function () {
                    API.close();
                })
            }, 100);
        });
        API.bind("close:start", function () {
            setTimeout(function () {
                $icon.removeClass("is-active");
            }, 100);
        });
    }

    // HOMEPAGE - GALLERY RANDOM
    // Tableau des images de la banque
    var ids = [];

    function initArray() {
        $(".img-bank img").each(function () {
            ids.push($(this).attr("src"));
        });
    }

    initArray();

    // Fn - Changement du visuel
    function changeSrc() {
        // Prendre une div au hasard sur les 7
        var cells = $(".galery .block-img");
        var randomId = (Math.floor(Math.random() * cells.length));
        // Prendre une image au hasard de la banque
        var randomImgFromBank = ids[Math.floor(Math.random() * ids.length)];
        // Si l'image est déjà présente, relancer la fonction
        if ($(".galery img[src='" + randomImgFromBank + "']:visible").length > 0) {
            changeSrc();
        } else {
            // Prendre une div au hasard sur les 7
            var cell = cells.eq(randomId);
            // Changement l'image hidden de cette div
            cell.find("img:hidden").each(function () {
                $(this).attr("src", randomImgFromBank);
            });
            // toggleFade les images
            cell.find("img").fadeToggle(2000);
        }
    }

    // Lancer la fonction toutes les x secondes
    setInterval(function () {
        changeSrc();
    }, 2000);

    if (isMobile) {
        // Galery homepage
        $(".galery .js-remove-mobile").remove();
        // Slick homepage + marchés
        $(".js-galery-slick").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            centerMode: true
        });
    }

    // HOMEPAGE - HIGHLIGHT BLOCK TXT GALLERY RANDOM
    if ($(".galery .block-txt").length) {

        $(".block-txt li:first-child").addClass("highlight");
        setInterval(elemAnim, 3000);

        function elemAnim() {
            var current = $(".block-txt li.highlight");
            current.toggleClass("highlight");
            var next = current.next();
            if (current.is($(".block-txt li:last-child"))) {
                next = $(".block-txt li:first-child");
            }
            next.toggleClass("highlight");
        }
    }

    // HOMEPAGE - SCROLL GALLERY LOGO
    function scrollMove(ele, frame, step) {
        var step = step || 1;
        var $item = $(ele).children();
        var w = 0;
        $item.each(function () {
            w += $(this).width();
        });

        $(ele).html($(ele).html() + $(ele).html());

        var $items = $(ele);

        var temp = 0;

        function move() {
            if (temp > w) {
                temp = 0
            } else {
                temp = temp + step;
            }
            $items.scrollLeft(temp);
        }

        setInterval(move, 800 / frame);
    }

    scrollMove('.items', 60, 1);

    // HOMEPAGE - FULLWIDH BG IMAGES - HIGHLIGHT BLOCK TXT GALLERY RANDOM
    if ($(".full-width-bg .imgs-bg").length) {

        $(".imgs-bg div:first-child").addClass("current");
        setInterval(elemAnim, 5000);

        function elemAnim() {
            var current = $(".imgs-bg div.current");
            current.toggleClass("current");
            var next = current.next();
            if (current.is($(".imgs-bg div:last-child"))) {
                next = $(".imgs-bg div:first-child");
            }
            next.toggleClass("current");
        }
    }

    // ANCHORS SMOOTH
    $(function () {
        // ON LOAD
        function smoothScrollTo(target) {
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1500);
            }
        }

        if (location.hash) {
            window.scrollTo(0, 0);
            target = location.hash.split('#');
            smoothScrollTo($('#' + target[1]));
        }

        // ON CLICK
        $("a[href*='#']:not([href='#'])").click(function () {
            if (
                location.hostname == this.hostname
                && this.pathname.replace(/^\//, "") == location.pathname.replace(/^\//, "")
            ) {
                var anchor = $(this.hash);
                anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) + "]");
                if (anchor.length) {
                    $("html, body").animate({scrollTop: anchor.offset().top}, 1500);
                }
            }
        });
    });

    // NAV PAGE METIER
    if ($("#jobs").length) {

        // Slide Up all the interviews
        const closeAllInterviewsContent = function () {
            $(".js-read-more").removeClass("opened").prev().slideUp();
        };

        const jobsNavItem = $(".navigation a");

        const handleMultipleInterviews = function (interviewWrapper, jobContent) {
            if (interviewWrapper.length && interviewWrapper[0].children.length > 1) {
                const avatar = jobContent.find('.testimonial > div > img');
                const thumbsWrapper = jobContent.find('.js-thumbs-wrapper');

                // Show title
                jobContent.find('.js-title-jobs').show();

                if (avatar.length > 1) {
                    // Reset
                    $('.slick-initialized').each(function () {
                        $(this).slick('unslick')
                    });
                    thumbsWrapper.empty();

                    // Fill with thumbs
                    for (let i = 0; i < avatar.length; i++) {
                        const element = $('<div class="item-thumbs"></div>');
                        $(avatar[i])
                            .clone()
                            .appendTo(element);
                        element.appendTo(thumbsWrapper)
                    }

                    // Slick the thumbs
                    $(thumbsWrapper).slick({
                        slidesToShow: 6,
                        slidesToScroll: 6,
                        infinite: false,
                        asNavFor: interviewWrapper,
                        focusOnSelect: true,
                        arrows: false,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 4
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3
                                }
                            }
                        ]
                    });
                }

                // Slick the interviews
                $(interviewWrapper).slick({
                    infinite: false,
                    asNavFor: thumbsWrapper,
                })
            }
        };

        jobsNavItem.on("click", function (e) {
            e.preventDefault();
            closeAllInterviewsContent();

            if (!$(this).hasClass("current")) {
                const eltPosition = $(this).parent().index();
                const newJobContent = $("#jobs .job:nth-child(" + (eltPosition + 2) + ")");

                jobsNavItem.removeClass("current");
                $(this).addClass("current");
                $(".job").hide();
                $(newJobContent).fadeIn("slow");
                $("html, body").animate({scrollTop: 0}, "slow");

                const interviewWrapper = newJobContent.find('.js-interviews-wrapper > div');
                handleMultipleInterviews(interviewWrapper, newJobContent);
            }
        });

        // Close all the interviews content on change slide
        $(".js-interviews-wrapper > div").on('beforeChange', function (slick) {
            console.log(slick);
            closeAllInterviewsContent();
            $('html, body').animate({scrollTop: $(slick.target).offset().top -100}, 'slow');
        });

        $(".cross-close").on("click", function () {
            jobsNavItem.removeClass("current");
            $(".job").hide();
            $(".job.intro").fadeIn("slow");
        });

        // DISPLAY CONTENT BY URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        const anchor = getParameterByName('content');
        if (anchor) {
            const jobContent = $(".job#js-content-" + anchor);
            $(("a#js-link-" + anchor)).addClass("current");
            $(".job").hide();
            jobContent.fadeIn("slow");

            // If multiple interview
            const interviewWrapper = $('.job#js-content-' + anchor + ' .js-interviews-wrapper > div');
            handleMultipleInterviews(interviewWrapper, jobContent);
        }

        // PAGE METIER RESOLUTION HEIGHT = SHORT
        if (!isTabletOrLess) {
            const navHeight = $("#jobs > .navigation").height();
            const windowHeight = $(window).height();

            if ((navHeight) > windowHeight) {
                $("#jobs > .navigation .inner").addClass("short").height(windowHeight - 270);
            }
        }
    }

    // READ MORE
    $(".js-read-more").on("click", function () {
        $(this).toggleClass("opened").prev().slideToggle();
    });

    // PAGE CANDIDATURE SPONTANEE
    if ($('.webform-submission-form').length) {
        // Function
        var checkValue = function (e) {
            tmpval = e.val();
            if (tmpval === '') {
                e.addClass('js-empty').removeClass('js-not-empty');
            } else {
                e.addClass('js-not-empty').removeClass('js-empty');
            }
        };
        // Var Elts
        var formElts = $('input, textarea');
        // 1er chargement
        formElts.each(function () {
            checkValue($(this));
        });
        // Au clic sur l'elt
        formElts.blur(function () {
            checkValue($(this));
        });
    }

    // LIRE PLUS
    if (isMobile) {
        $(".js-slide-toggle").on("click", function () {
            $(this).prev().slideToggle();
            $(".js-slide-toggle span").toggle();
        })
    }

    // SWITCH LANGUE
    $('a.language-link.is-active').on("click", function (e) {
        e.preventDefault();
    });

    var listLangWrapper = $('#block-selecteurdelangue .links');
    listLangWrapper.on("click", function () {
        $(this).toggleClass("open");
    });
    $('#block-selecteurdelangue li.is-active').prependTo(listLangWrapper);

    if (isTabletOrLess) {
        $("#block-selecteurdelangue").prependTo("header");
    }
});