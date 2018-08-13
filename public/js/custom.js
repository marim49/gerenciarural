
/*=============================================================
    Authour URI: www.binarytheme.com
    License: Commons Attribution 3.0

    http://creativecommons.org/licenses/by/3.0/

    100% Free To use For Personal And Commercial Use.
    IN EXCHANGE JUST GIVE US CREDITS AND TELL YOUR FRIENDS ABOUT US
   
    ========================================================  */

(function ($) {
    "use strict";
    var mainApp = {
        slide_fun: function () {

            $('#carousel-example').carousel({
                interval: 3000 // THIS TIME IS IN MILLI SECONDS
            })

        },
        dataTable_fun: function () {

            $('#dataTables-example').dataTable();

        },




        custom_fun: function () {
            /*====================================
             WRITE YOUR   SCRIPTS  BELOW
            ======================================*/

            // Soma de resultados da tabela
            
            $(document).ready(function () {
                $('#example').DataTable({
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(4)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        pageTotal = api
                            .column(4, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Update footer
                        $(api.column(4).footer()).html(
                            '$' + pageTotal + ' ( $' + total + ' total)'
                        );
                    }
                });
            });



        },

    }


    $(document).ready(function () {
        mainApp.slide_fun();
        mainApp.dataTable_fun();
        mainApp.custom_fun();
    });
}(jQuery));


$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
});



