jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;

    // FAKE LINK FOR SUBMENUS
    $(".js-fake-link").click(function (e) {
        e.preventDefault();
    });

    // NAV MOBILE
    if (isTabletOrLess) {
        $(".navbar-toggler").click(function() {
            $(this).toggleClass("is-active");
            $("#nav-wrapper").toggleClass("active");
            $("#content-wrap > .container-fluid").toggleClass("disable");
            $("body").toggleClass("disable");
        });

        $("#nav-wrapper a.dd").click(function(e) {
            e.preventDefault();
            $(this).toggleClass("opened");
            $(this).parent().find("ul").slideToggle();
        });
    }

    // HP - Slick
    $(".js-slides-wrapper").slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        fade: true,
        cssEase: 'linear'
    });

    // INSTAGRAM-FEED
    if ($('#instagram-feed').length) {
        const instagramFeedWrapper = $("#instagram-feed");

        const slickInstagramFeed = function() {
            instagramFeedWrapper.slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 990,
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
                            centerMode: true,
                            centerPadding: '30px'
                        }
                    }
                ]
            });
        };

        $.instagramFeed({
            'username': 'comptoirdefamilleofficiel',
            'get_data': true,
            'callback': function(data){
                let dataItem = data.edge_owner_to_timeline_media.edges;

                for (let i = 0; i < dataItem.length && i < 8; i++) {
                    instagramFeedWrapper.append(`
                        <div>
                            <a href="${'https://www.instagram.com/p/' + dataItem[i].node.shortcode + '/'}" target="_blank">
                                <img src="${dataItem[i].node.thumbnail_src}" />
                                <div class="inner-infos d-flex">
                                    <div>
                                        <div class="likes">
                                            ${dataItem[i].node.edge_liked_by.count}
                                        </div>
                                        <div class="comments">
                                            ${dataItem[i].node.edge_media_to_comment.count}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `);
                }

                $(".loading").hide();
                slickInstagramFeed();
            }
        });
    }

    // LA MARQUE - Slick
    var marqueSlider = $(".js-slides-ambiances > div > div:nth-child(2)");
    marqueSlider.slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // PAGE CONTACT
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
        // Required
        $(".required").parent().addClass("required-wrapper");
    }

    // PARUTION PRESSE
    $(".js-link-pdf").click(function () {
        var link = $(this).attr("data-link");
        $(".js-pdf-embed").attr("src",link);
    });

    // STORE LOCATOR
    if ($(".store-locator").length) {
        $(this).on("click", '.phone', function(e) {
            e.preventDefault();
            $(this).find(".txt").toggle();
            $(this).find(".number").toggle();
        });
    }
});