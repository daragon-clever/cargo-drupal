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

    // HOMEPAGE - SCROLL GALLERY LOGO
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

    // NAV PAGE METIER
    if ($("#jobs").length) {

        /* var elementHeights = $('.job').map(function() {
            return $(this).height();
        }).get();

        var maxHeight = Math.max.apply(null, elementHeights);

        var jobsHeightAjust = function() {
            $("#jobs").height(maxHeight + 125);
        };

        jobsHeightAjust(); */

        var jobsNavItem = $(".navigation a");

        jobsNavItem.on("click", function (e) {
            e.preventDefault();
            if (!$(this).hasClass("current")) {
                var eltPosition = $(this).parent().index();
                var newJobContent = $("#jobs .job:nth-child(" + (eltPosition + 2) + ")");
                jobsNavItem.removeClass("current");
                $(this).addClass("current");
                $(".job").hide();
                $(newJobContent).fadeIn("slow");
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        });

        $(".cross-close").on("click", function () {
            jobsNavItem.removeClass("current");
            $(".job").hide();
            $(".job.intro").fadeIn("slow");
        });

        $(".js-read-more").on("click", function () {
            $(this).toggleClass("opened").prev().slideToggle();
        });

        // DISPLAY CONTENT BY URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
        var anchor = getParameterByName('content');
        if (anchor.length) {
            $(("a#js-link-" + anchor)).addClass("current");
            $(".job").hide();
            $(".job#js-content-" + anchor).fadeIn("slow");
        }
    }

    // PAGE CANDIDATURE SPONTANEE
    if ($('.webform-submission-form').length) {
        $('input, textarea').blur(function () {
            tmpval = $(this).val();
            if (tmpval == '') {
                $(this).addClass('js-empty').removeClass('js-not-empty');
            } else {
                $(this).addClass('js-not-empty').removeClass('js-empty');
            }
        });
    }

    //PAGE OFFRE EMPLOI - AUDREY - NICO
    if ($('.listing-offres').length) {
        var table = $("#toutes-les-offres").DataTable({
            //config
            dom: 'tp',
            language: {
                url: "http://cdn.datatables.net/plug-ins/1.10.19/i18n/French.json",//todo
                searchPlaceholder : "Rechercher une offre"
            },
            //pages
            pagingType: "numbers",
            pageLength: 10,
            //date
            order:[3,'desc'],//en fonction d'une date précise
            "aoColumnDefs": [
                { "sType": "date-uk", "aTargets": [ 3 ] }
            ],
            //filters
            initComplete: function () {
                //les filtres
                this.api().columns([1,2,4]).every( function () {
                    switch (this[0][0]) {
                        case 1:
                            var selector = '#filtre-contrat .select-option';
                            var filter = my_filter_value_type_contrat;
                            break;
                        case 2:
                            var selector = '#filtre-poste .select-option';
                            var filter = my_filter_value_type_metier;
                            break;
                        case 4:
                            var selector = '#filtre-lieu .select-option';
                            var filter = my_filter_value_lieu;
                            break;
                    }

                    var column = this;
                    var select = $('<select><option value="">Voir tous</option></select>').appendTo( $(selector) );

                    //filtre lors d'un change
                    select.on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );

                    //remplie le select
                    var ready = (function(){
                        column.data().unique().sort().each( function ( d, j ) {
                            var cleanvalue = cleanStr(d);
                            select.append( '<option value="'+cleanvalue+'">'+d+'</option>' );
                        } );
                    })();

                    $.when(select, ready).done( function () {
                        if (filter != "") {
                            var cleanfilter = cleanStr(filter).replace('-',' ');
                            console.log(cleanfilter);
                            $(selector + ' option[value="' + cleanfilter + '"]').attr('selected', 'selected');
                            select.trigger("change");
                        }
                    });

                } );

                // Select2 filters
                $('.select-option select').select2({
                    minimumResultsForSearch: Infinity
                });
            }
        });

        //date
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function ( a ) {
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        } );

        //search input
        $("#searchbox").keyup(function() {
            table.search(this.value).draw();
        });

        // Clickable full row
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        //remove accent and set lower case
        function cleanStr(str) {
            var accents    = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
            var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
            str = str.split('');
            var strLen = str.length;
            var i, x;
            for (i = 0; i < strLen; i++) {
                if ((x = accents.indexOf(str[i])) != -1) {
                    str[i] = accentsOut[x];
                }
            }
            return str.join('').toLowerCase();
        }
    }
});