<!DOCTYPE html>
<html>
  <head>
    <meta Content-Disposition: attachment; filename="filename.ext">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ssi-modal/styles/ssi-modal.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/prettyPhoto.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.datatables.yadcf.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/fixedColumns.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/responsive.dataTables.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css"> -->
    <!-- Font-icon css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/customer.css">
    <title>HungMinh Admin</title>
    <script src="<?php echo base_url(); ?>js/jquery-2.1.4.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-mini fixed">
    <div class="wrapper">
	<!-- Đây là header của trang -->    
    <?php echo isset($html_header) ? $html_header : ''; ?>
    <!-- Đây là nội dung của trang -->    
    <?php echo isset($html_body) ? $html_body : ''; ?>
    <!-- Đây là footer của trang -->    
    <?php echo isset($html_footer) ? $html_footer : ''; ?>	
	</div>
	<!-- Javascripts-->
	<script src="<?php echo base_url(); ?>js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url();?>js/plugins/jquery.isotope.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/pace.min.js"></script>
    <script src="<?php echo base_url(); ?>js/main.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/dataTables.fixedColumns.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/jquery.dataTables.yadcf.js"></script>
    <script type="text/javascript">
       
        $(document).ready(function() {
            var table = $('#sampleTable').DataTable( {
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    total1 = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    total2 = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        'Tổng: '+total1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' VNĐ'
                    );
                    $( api.column( 4 ).footer() ).html(
                        'Tổng: '+total2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' VNĐ'
                    );
                },
                // initComplete: function () {
                //     this.api().columns([4,5]).every( function () {
                //         var column = this;
                //         var select = $('<select><option value=""></option></select>')
                //             .appendTo( $(column.footer()).empty() )
                //             .on( 'change', function () {
                //                 var val = $.fn.dataTable.util.escapeRegex(
                //                     $(this).val()
                //                 );
         
                //                 column
                //                     .search( val ? '^'+val+'$' : '', true, false )
                //                     .draw();
                //             } );
         
                //         column.data().unique().sort().each( function ( d, j ) {
                //             select.append( '<option value="'+d+'">'+d+'</option>' )
                //         } );
                //     } );
                // },
                 // scrollX:        true,
                //scrollCollapse: true,
                // fixedColumns:   {
                //     leftColumns: 1,
                //     rightColumns: 1
                // },
                colReorder: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:   0
                } ],
                order: [1, "desc"],
            });
            $('#s-icons').click(function() {
                $('.navbar-nav').toggleClass("show");
            });
            $('#sampleTable').dataTable().yadcf([
                {column_number : 5,  sort:"num", filter_container_id: "external_filter_container"},
            ]);
        });
    </script>
    <script src="<?php echo base_url(); ?>ssi-modal/js/ssi-modal.js"></script>
    <script src="<?php echo base_url(); ?>js/formvalidate.js"></script>
  </body>
</html>