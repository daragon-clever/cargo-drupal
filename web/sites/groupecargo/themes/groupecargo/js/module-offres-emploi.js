jQuery(document).ready(function($) {
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

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
                            var cleanvalue = replaceSpecialChar(d);
                            select.append( '<option data-clean="'+cleanvalue+'" value="'+d+'">'+d+'</option>' );
                        } );
                    })();

                    $.when(select, ready).done( function () {
                        if (filter != "") {
                            var cleanfilter = replaceSpecialChar(filter);
                            if ($(selector + ' option[data-clean="' + cleanfilter + '"]').length) {
                                $(selector + ' option[data-clean="' + cleanfilter + '"]').attr('selected', 'selected');
                                select.trigger("change");
                            } else {
                                $('#alerte-offres').html("<div class='error'>Il n'y a pour le moment aucune offre disponible pour ce type de poste</div>");
                            }
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

        //replace array of characters by "-"
        function replaceSpecialChar(metier){
            return cleanStr(metier).replace(/[^a-zA-Z0-9]/g, '-');
        }

    }
});