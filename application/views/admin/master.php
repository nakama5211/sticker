<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ssi-modal/styles/ssi-modal.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <script src="<?php echo base_url(); ?>js/plugins/pace.min.js"></script>
    <script src="<?php echo base_url(); ?>js/main.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"order":[[ 0, "desc" ]]});</script>
    <script src="<?php echo base_url(); ?>ssi-modal/js/ssi-modal.js"></script>
    <script src="<?php echo base_url(); ?>js/formvalidate.js"></script>
  </body>
</html>