jQuery(document).ready(function($) {
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return "";
        }
        return decodeURI(results[1]) || 0;
    };

    var expireCookiesTime = new Date();
    var minutes = 15;
    expireCookiesTime.setTime(expireCookiesTime.getTime() + (minutes * 60 * 1000));

    //PAGE OFFRE EMPLOI
    if ($('.listing-offres').length) {

        //variables
        var myTable = [];
        myTable[2] = {
            field_name: 'Type de contrat',
            cookie_name: 'typeDeContrat',
            id_selector: 'filtre-contrat',
            filter_param: 'type_contrat'
        };
        myTable[3] = {
            field_name: 'Type de poste',
            cookie_name: 'typeDePoste',
            id_selector: 'filtre-poste',
            filter_param: 'type_metier'
        };
        myTable[5] = {
            field_name: 'Lieu',
            cookie_name: 'lieuDeTravail',
            id_selector: 'filtre-lieu',
            filter_param: 'lieu'
        };

        $.fn.dataTable.moment( 'DD/MM/YYYY' );

        // Clickable full row
        var clickableRow = function() {
            if (isMobile === false) {
                $(".clickable-row").unbind().click(function(e) {
                    e.preventDefault();
                    if (e.ctrlKey) {
                        //ctrl + Click
                        window.open($(this).data("href"));
                    } else {
                        //simple Click
                        window.location = $(this).data("href");
                    }
                });
                $(".clickable-row").mousedown(function(e) {
                    e.preventDefault();
                    if (e.which === 2) {
                        //middle Click
                        window.open($(this).data("href"));
                    }
                    return true;
                });
            }
        };

        // Config datatable listing && filters
        var table = $("#toutes-les-offres").DataTable({
            dom: 'tp',
            language: {
                "url": "/sites/cogex/themes/cogex/js/datatables-french.json",
            },
            pagingType: "numbers",
            pageLength: 10,
            order:[4,'desc'],//order by date - column n°3
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },

            //filters
            initComplete: function () {
                //create filter on 3 columns
                this.api().columns([2,3,5]).every( function () {
                    var column = this;
                    var colNumb = this[0][0];

                    var selector = (myTable[colNumb]) ? '#' + myTable[colNumb].id_selector + ' .select-option' : undefined;
                    var nameCookies = (myTable[colNumb]) ? myTable[colNumb].cookie_name : undefined;

                    //init select box
                    var select = $('<select><option value="">Voir tous</option></select>').appendTo( $(selector) );

                    //filtering rows on select change
                    select.on( 'change', function () {
                        //get value of select
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        //get attr value of select
                        var valForCookie = $('option:selected', this).data('clean');
                        //save value in cookies
                        Cookies.set(nameCookies, valForCookie, { expires : expireCookiesTime });

                        //filter data on table
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );

                    //remplie le select
                    var ready = (function(){
                        column.data().unique().sort().each( function ( d, j ) {
                            var cleanvalue = replaceSpecialChar(d);
                            select.append( '<option data-clean="'+cleanvalue+'" value="'+d+'">'+d+'</option>' );
                        } );
                    })();

                } );

                //get url params to filter
                this.api().columns([2,3,5]).every( function () {
                    var priorityCookie = true;
                    var colNumb = this[0][0];

                    var selector = (myTable[colNumb]) ? '#' + myTable[colNumb].id_selector + ' .select-option' : undefined;
                    var filter = (myTable[colNumb]) ? $.urlParam(myTable[colNumb].filter_param) : undefined;
                    var cookies = (myTable[colNumb]) ? Cookies.get(myTable[colNumb].cookie_name) : undefined;

                    if (colNumb === 3) {
                        var oldParam = Cookies.get('oldParam');
                        if (oldParam != replaceSpecialChar(filter)) {
                            var priorityCookie = false;
                        }
                        Cookies.set('oldParam', replaceSpecialChar(filter), { expires : expireCookiesTime });
                    }

                    var select = $(selector + " select");

                    //priorité cookies
                    if (priorityCookie === true && cookies != ""
                        && $(selector + ' option[data-clean="' + cookies + '"]').length
                    ) {
                        $(selector + ' option[data-clean="' + cookies + '"]').attr('selected', 'selected');
                        select.trigger("change");
                    } else if (filter != "") {
                        var cleanfilter = replaceSpecialChar(filter);
                        if ($(selector + ' option[data-clean="' + cleanfilter + '"]').length) {
                            $(selector + ' option[data-clean="' + cleanfilter + '"]').attr('selected', 'selected');
                            select.trigger("change");
                        } else {
                            console.log('error');
                            $('#alerte-offres').html("<div class='error'>Il n'y a pour le moment aucune offre disponible pour ce type de poste</div>");
                        }
                    }
                });

                // Select2 filters
                $('.select-option select').select2({
                    minimumResultsForSearch: Infinity
                });
            }
        });

        $.when(table).done( function () {
            table.on('draw', function () {
                table.columns().indexes().each( function ( idx ) {
                    switch (idx) {
                        case 2:
                            var selector = '#filtre-contrat .select-option';
                            var filter = $.urlParam('type_contrat');//get url param value
                            break;
                        case 3:
                            var selector = '#filtre-poste .select-option';
                            var filter = $.urlParam('type_metier');
                            break;
                        case 5:
                            var selector = '#filtre-lieu .select-option';
                            var filter = $.urlParam('lieu');
                            break;
                    }

                    var select = $(selector + " select");

                    if ( select.val() === '' ) {
                        select.empty().append('<option value="">Voir tous</option>');

                        table.column(idx, {search:'applied'}).data().unique().sort().each( function ( d, j ) {
                            var cleanvalue = replaceSpecialChar(d);
                            select.append( '<option data-clean="'+cleanvalue+'" value="'+d+'">'+d+'</option>' );
                        } );
                    }
                } );

                // Select2 filters
                $('.select-option select').select2({
                    minimumResultsForSearch: Infinity
                });
            } );
        });

        // Masquer la colonne qui sert aux filtres
        table.columns( '.js-hide' ).visible( false );

        if (isMobile === false) {
            table.columns( '.js-only-xs' ).visible( false );
        }

        $('#toutes-les-offres').on('draw.dt', function () {
            clickableRow();//Permet d'activer le click sur les lignes de TOUT le tableau et pas que la première page
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

        //replace array of characters by "-" + remove accent and set lower case
        function replaceSpecialChar(str) {
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
            var final = str.join('').toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
            return final;
        }
    }
});