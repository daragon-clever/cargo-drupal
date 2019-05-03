jQuery(document).ready(function($) {
    var isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return "";
        }
        return decodeURI(results[1]) || 0;
    }

    //PAGE OFFRE EMPLOI
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
            dom: 'tp',//tpl
            language: {
                "url": "/sites/groupecargo/themes/groupecargo/js/datatables-french.json",
            },
            pagingType: "numbers",
            pageLength: 10,
            order:[3,'desc'],//order by date
            responsive: true,//responsive

            //filters
            initComplete: function () {
                //create filter on 3 columns
                this.api().columns([1,2,4]).every( function () {
                    switch (this[0][0]) {
                        case 1:
                            var selector = '#filtre-contrat .select-option';
                            break;
                        case 2:
                            var selector = '#filtre-poste .select-option';
                            break;
                        case 4:
                            var selector = '#filtre-lieu .select-option';
                            break;
                    }

                    var column = this;
                    var select = $('<select><option value="">Voir tous</option></select>').appendTo( $(selector) );

                    //filtering rows on select change
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

                } );
                this.api().columns([1,2,4]).every( function () {
                    switch (this[0][0]) {
                        case 1:
                            var selector = '#filtre-contrat .select-option';
                            var filter = $.urlParam('type_contrat');
                            break;
                        case 2:
                            var selector = '#filtre-poste .select-option';
                            var filter = $.urlParam('type_metier');
                            break;
                        case 4:
                            var selector = '#filtre-lieu .select-option';
                            var filter = $.urlParam('lieu');
                            break;
                    }
                    var select = $(selector + " select");

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

                // Select2 filters
                $('.select-option select').select2({
                    minimumResultsForSearch: Infinity
                });

                // Clickable Row
                clickableRow();
            }
        });

        $.when(table).done( function () {
            table.on('draw', function () {
                table.columns().indexes().each( function ( idx ) {
                    switch (idx) {
                        case 1://ou -1
                            var selector = '#filtre-contrat .select-option';
                            var filter = $.urlParam('type_contrat');//get url param value
                            break;
                        case 2:
                            var selector = '#filtre-poste .select-option';
                            var filter = $.urlParam('type_metier');
                            break;
                        case 4:
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