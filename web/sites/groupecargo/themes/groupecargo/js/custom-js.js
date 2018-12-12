jQuery(document).ready(function($) {
    // NAV
    $("#header-wrapper nav").hover(function () {
        $("#header-wrapper").toggleClass("menu-hover");
    });

    // NAV MOBILE
    $(".navbar-toggler").on( "click", function() {
        alert("ok");
    });

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
        var cells = $(".galery .col-3");
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
});