<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Stationary</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo $this->Html->meta('icon');?>
    <?Php echo $this->Html->css(array('plugins/fontawesome-free/css/all.min.css','plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css','plugins/icheck-bootstrap/icheck-bootstrap.min.css','plugins/jqvmap/jqvmap.min.css','adminlte.min.css','plugins/overlayScrollbars/css/OverlayScrollbars.min.css','plugins/daterangepicker/daterangepicker.css','plugins/summernote/summernote-bs4.min.css','plugins/select2/css/select2.min.css','plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css','jquery.dataTables.min.css'));?>
    <script type="text/javascript">
      var webURL='<?php echo webURL; ?>';
      </script>
      <style type="text/css">
          p.error-message {
                color: #f90303;
            }
            .error {
                color: #f90303;
            }
            .submit input[type="submit"]{
                    position: absolute;
                    top: 0px;
                    right: 8px;
                    height: 30px;
                    border: none;
            }
            span.required {
                color: red;
            }
            /*for pagination*/
            .pagination {
                list-style: none;
                padding: 0;
                margin: 20px 0;
                text-align: center;
            }

            .pagination li {
                display: inline;
            }

            .pagination li a,
            .pagination li span {
                padding: 6px 12px;
                text-decoration: none;
                border: 1px solid #ddd;
                margin: 0 4px;
                color: #333;
            }

            .pagination li.active a,
            .pagination li.active span {
                background-color: #007bff;
                color: #fff;
                border-color: #007bff;
            }

            .pagination li.disabled a,
            .pagination li.disabled span {
                color: #999;
                pointer-events: none;
                cursor: default;
            }
            .stock-list-container ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .stock-list-container li {
        padding: 8px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .stock-list-container li:last-child {
        border-bottom: none;
    }

    .stock-list-container li:hover {
        background: #f0f0f0;
    }

    .out-of-stock {
        color: red;
        font-weight: bold;
        cursor: not-allowed;
        background-color: #f8d7da; /* Light red background */
    }
    .select2 {
    display: block;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
}
.select2-container--default .select2-selection--single {
    border: none;
    padding: 0;
}

      </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/dddd.gif" alt="logo" height="60" width="60">
  </div>
<h3 class="text-center" style="color: red;margin-top: 40px;text-decoration: underline;">Superadmin Dashboard</h3>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a class="dropdown-item" href="<?php echo webURL?>super/changePassword"><i class="fas fa-edit mr-2"></i> Change Password</a>
          <a href="<?php echo webURL?>users/logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>  
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
<?php echo $this->element('supersidebar');?>
  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

<?php echo $this->fetch('content');?>
    
  </div>
  <!-- /.content-wrapper -->
  <?php echo $this->element('footer');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php echo $this->Html->script(array('plugins/jquery/jquery.min.js','plugins/select2/js/select2.full.min.js','plugins/jquery-ui/jquery-ui.min.js','plugins/bootstrap/js/bootstrap.bundle.min.js','plugins/jquery-validation/jquery.validate.min.js','plugins/jquery-validation/additional-methods.min.js','plugins/moment/moment.min.js','plugins/daterangepicker/daterangepicker.js','plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js','plugins/summernote/summernote-bs4.min.js','plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js','adminlte.js','demo.js','custom.js','admin.js','jquery.dataTables.min.js','dataTables.buttons.min.js','buttons.html5.min.js','buttons.print.min.js','buttons.colVis.min.js','jszip.min.js','pdfmake.min.js','vfs_fonts.js'));?>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    $('#todate').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('#fromdate').datetimepicker({
        format: 'DD/MM/YYYY'
    });

  })
</script>

<script>
    document.getElementById('limit').addEventListener('change', function() {
        document.getElementById('submitsort').submit();
    });
</script>

<?= $this->Html->scriptBlock(
    'var csrfToken = ' . json_encode($this->request->getAttribute('csrfToken'))
); ?>


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<div class="bhashini-plugin-container"></div>
<script src="https://translation-plugin.bhashini.co.in/v2/website_translation_utility.js"></script>
</body>
</html>