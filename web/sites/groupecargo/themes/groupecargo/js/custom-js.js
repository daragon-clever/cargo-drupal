jQuery(document).ready(function($) {
    // NAV
    $("#header-wrapper nav").hover(function () {
        $("#header-wrapper").toggleClass("menu-hover");
    });

    // NAV MOBILE
    if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        var $menu = $("#block-groupecargo-main-menu").mmenu({
            "extensions": [
                "theme-white",
                "border-full",
                "position-front",
                "pagedim-black"
            ]
        }, {
            clone: true
        });

        var $icon = $(".navbar-toggler");
        var API = $menu.data("mmenu");

        API.bind( "open:start", function() {
            setTimeout(function() {
                $icon.addClass( "is-active" );
                $icon.on("click",function() {
                    API.close();
                })
            }, 100);
        });
        API.bind( "close:start", function() {
            setTimeout(function() {
                $icon.removeClass( "is-active" );
            }, 100);
        });
    }

    // HOMEPAGE - GALLERY RANDOM
    var ids = [];

    function initArray() {
        $(".img-bank img").each(function() {
            ids.push($(this).attr("src"));
        })
    }

    function randomArray() {
        // copie du tableau d'ids car il va etre modifié
        var tempIds = ids.slice();
        // init du tableau de resultat
        var myIds = [];
        for (var i = 0; i < 6; i++) {
            // Recupere un int random
            var randomId = (Math.floor(Math.random() * tempIds.length) + 1);
            // Recupere la valeur random
            var myId = tempIds[randomId - 1];
            // Ajout de la valeur random au tableau de resultat
            myIds.push(myId);
            // Recupere l'index de la valeur random pour la suppression
            var pos = tempIds.indexOf(myId);
            // Suppression de la valeur choisie pour eviter de retomber dessus
            tempIds.splice(pos, 1);
        }
        return myIds;
    }

    initArray();

    function changeSrc() {

        // Random one ID of the 6 displayed images
        var cells = $(".galery .block-img");
        var randomId = (Math.floor(Math.random() * cells.length));

        // Get first result
        var result = randomArray();
        var randomImgFromBank = $(".img-bank img").attr("src");
        // var randomIdImgFromBank = (Math.floor(Math.random() * randomImgFromBank.length));
        var newsrc = result[0];

        // if src is already displayed, relaunch
        if ($(".galery img[src='" + newsrc + "']:visible").length > 0) {
            changeSrc();
        }
        else {
            // Get one random div of the 6 displayed images
            var cell = cells.eq(randomId);
            // for each hidden image in the div, change the src
            cell.find("img:hidden").each(function() {
                $(this).attr("src", newsrc);
            });
            // toggleFade images of this div
            cell.find("img").fadeToggle(1500);
        }
    }

    setInterval(function() {
        changeSrc();
    }, 2000);

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

    // SCROLLL GALLERY
    function scrollMove( ele ,frame ,step ) {
        var step = step || 1;
        var $item = $(ele).children();
        var w = 0 ;
        $item.each(function () {
            w += $(this).width();
        });

        $(ele).html( $(ele).html() + $(ele).html() );

        var $items = $(ele);

        var temp = 0;
        function move() {
            if( temp > w ){
                temp = 0
            }else{
                temp = temp+step ;
            }
            $items.scrollLeft( temp );
        }
        setInterval(move , 800 / frame);
    }

    scrollMove('.items', 60 , 1 );

    // FULLWIDH BG IMAGES - HOMEPAGE - HIGHLIGHT BLOCK TXT GALLERY RANDOM
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
    $(function() {
        // ON LOAD
        function smoothScrollTo(target) {
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1500);
            }
        }
        if (location.hash) {
            window.scrollTo(0, 0);
            target = location.hash.split('#');
            smoothScrollTo($('#'+target[1]));
        }

        // ON CLICK
        $("a[href*='#']:not([href='#'])").click(function() {
            if (
                location.hostname == this.hostname
                && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
            ) {
                var anchor = $(this.hash);
                anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
                if ( anchor.length ) {
                    $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
                }
            }
        });
    });
});