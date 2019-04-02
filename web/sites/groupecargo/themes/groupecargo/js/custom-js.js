jQuery(document).ready(function($) {
    // TEST MOBILE / TAB
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
    var isTabletOrLess = window.matchMedia("only screen and (max-width: 991px)").matches;
    // NAV
    $("#header-wrapper nav").hover(function () {
        $("#header-wrapper").toggleClass("menu-hover");
    });

    if ( isTabletOrLess ) {
        // NAV MOBILE
        var $menu = $("#block-groupecargo-main-menu").mmenu({
            "extensions": [
                "theme-white",
                "border-full",
                "position-front",
                "pagedim-black",
                "fullscreen"
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
    // Tableau des images de la banque
    var ids = [];
    function initArray() {
        $(".img-bank img").each(function() {
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
        var randomImgFromBank = ids[Math.floor(Math.random()*ids.length)];
        // Si l'image est déjà présente, relancer la fonction
        if ($(".galery img[src='" + randomImgFromBank + "']:visible").length > 0) {
            changeSrc();
        } else {
            // Prendre une div au hasard sur les 7
            var cell = cells.eq(randomId);
            // Changement l'image hidden de cette div
            cell.find("img:hidden").each(function() {
                $(this).attr("src", randomImgFromBank);
            });
            // toggleFade les images
            cell.find("img").fadeToggle(1500);
        }
    }
    // Lancer la fonction toutes les x secondes
    setInterval(function() {
        changeSrc();
    }, 1000);

    if ( isMobile ) {
        // Galery homepage
        $(".galery .js-remove-mobile").remove();
        // Slick homepage + marchés
        $(".js-galery-slick").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false,
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

        $.fn.dataTable.moment( 'DD/MM/YYYY' );

        // Clickable full row
        var clickableRow = function() {
            if (isMobile === false) {
                $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            }
        };

        var table = $("#toutes-les-offres").DataTable({
            //config
            dom: 'tp',
            language: {
                searchPlaceholder : "Rechercher une offre",
                emptyTable: "Nous n'avons pour le moment aucune offre d'emploi à proposer"
            },

            //pages
            pagingType: "numbers",
            pageLength: 10,

            //date
            order:[3,'desc'],//en fonction d'une date précise

            // Responsive
            responsive: true,

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

                // Clickable Row
                clickableRow();
            }
        });

        // Masquer la colonne qui sert aux filtres
        table.columns( '.js-hide' ).visible( false );

        if (isMobile === false) {
            table.columns( '.js-only-xs' ).visible( false );
        }

        $('#toutes-les-offres').on('draw.dt', function () {
            clickableRow();
        } );

        // Mobile : gestion btn filtres
        $(".js-toggle-filters").on("click", function () {
            $(".js-toggle-filters").toggle();
            $("#groupe-filtres-offres-emploi").slideToggle();
            $(".jobs-list").slideToggle();
        });

        //search input
        $("#searchbox").keyup(function() {
            table.search(this.value).draw();
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

    // LIRE PLUS
    if ( isMobile ) {
        $(".js-slide-toggle").on("click", function () {
            $(this).prev().slideToggle();
            $(".js-slide-toggle span").toggle();
        })
    }
});