<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
ini_set("auto_detect_line_endings", true);
ini_set('max_execution_time', 3600);
include("config.php");
require_once "assets/SimpleXLSX.php";
$b = new backend($host,$user,$password,$db);
if(isset($_SESSION['level'])){$classbody="class='hold-transition sidebar-mini layout-fixed'";}else{$classbody="class='hold-transition sidebar-mini layout-fixed'";}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $app;?></title>
  <meta name="viewport" content="width=device-width, initial-scale=0.8">
  <link rel="shortcut icon" type="image/png" href="<?php echo $base;?>/favicon.png"/>
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/summernote/summernote-bs4.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body <?php echo $classbody;?>>
<?php if(isset($_SESSION['level'])){ ?>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>      
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
	  <!--
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-power-off mr-2"></i> Logout
          </a>
        </div>
      </li>
	  -->
	  <!--
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
	  -->
	  
	  <!----------------------------------- >
		          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <img src="<?php echo $base;?>/favicon.png" class="user-image" alt="User Image">
                <!--<i class="fa fa-user text-success"></i>-->
                <span class="hidden-xs"></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <!--<i class="fa fa-user text-success"></i>-->
				  <img src="<?php echo $base;?>/favicon.png" class="user-image" alt="User Image">
                  <p>
                    <?php echo $_SESSION['nama'];?>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="float-left">
                    
                  </div>
                  <div class="float-right">
                    <a href="<?php echo $base;?>/action/logout" class="btn btn-default btn-sm btn-flat">Log out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
		<!------------------------------------->
	  
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $base;?>/action/dashboard" class="brand-link">
      <span class="brand-text font-weight-light"><h2>TOKO</h2><h3>Hesti</h3></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
	  
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <i class="fa fa-user text-success"></i> -->
		  <img src="<?php echo $base;?>/favicon.png" class="user-image" alt="User Image">
        </div>
        <div class="info">
          <?php if($_SESSION['level']=='admin'){?>
          <a href="<?php echo $base;?>/action/dashboard" class="d-block">Dashboard</a>
          <?php } ?>
        </div>
      </div>
		
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if($_SESSION['level']=='admin'){?> 
        <li class="nav-header">MASTER DATA</li>
		  <li class="nav-item">
            <a href="<?php echo $base;?>/table/admin" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Admin
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>	
		  <li class="nav-item">
            <a href="<?php echo $base;?>/table/supplier" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Supplier
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>	
		  <li class="nav-item">
            <a href="<?php echo $base;?>/table/barang" class="nav-link">
              <i class="nav-icon fas fa-pills"></i>
              <p>
                barang
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <?php } ?>
		  <li class="nav-header">TRANSAKSI</li>
      <?php if($_SESSION['level']=='admin'){?>
		  <li class="nav-item">
            <a href="<?php echo $base;?>/table/barang/action/create" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Restok
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>	
          <?php } ?>
		  <li class="nav-item">
            <a href="<?php echo $base;?>/action/penjualan" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Penjualan
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>	
		  <!------------------ ----->
      
				  <li class="nav-item">
            <a href="<?php echo $base;?>/action/laporan" class="nav-link">
              <i class="nav-icon far fa-clipboard"></i>
              <p>
                Laporan
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>	
        
        </ul>
		
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
		
        <!-- Main row -->
        <div class="row mt-2">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-clipboard mr-1"></i>
                  <?php if(isset($_REQUEST['action'])){echo ucwords(str_replace("_"," ",$_REQUEST['action']));}?>
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
<?php }?>
                  <?php $b->content();?>  
<?php if(isset($_SESSION['level'])){ ?>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            

            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->

          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    Copyright <strong> <?php echo $copyright;?>&copy; 2023</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<?php }?>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/moment/moment.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/dist/js/adminlte.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/dist/js/pages/dashboard.js"></script>
<script src="<?php echo $base;?>/assets/AdminLTE-3.0.5/dist/js/demo.js"></script>
</body>
</html>
