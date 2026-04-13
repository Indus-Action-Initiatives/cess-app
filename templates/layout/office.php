<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
		<title>BOCW - Office Dashboard</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
			.preloader{
				display: none;
			}
		</style>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<div class="preloader flex-column justify-content-center align-items-center">
				<img class="animation__shake" src="<?php echo webURL?>img/dddd.gif" alt="logo" height="60" width="60">
			</div>
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
				</ul>
				<?php $session = $this->request->getSession(); ?>
				<h3 class="text-center" style="color: #0d6efd;margin-top: 10px; text-align: center;">Officer Dashboard</h3>
				<span class="badge badge-primary py-2 ml-4"><?php echo $session->read('office.office_name') ?></span>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<span class="badge badge-primary py-2 mt-2 mr-2"><?php echo $session->read('office.officer_designation') ?></span>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
							<i class="far fa-user"></i> &nbsp; <?php echo $session->read('office.off_name') ?>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<a class="dropdown-item" href="<?php echo webURL?>admin/changePassword"><i class="fas fa-edit mr-2"></i> Change Password</a>
							<a href="<?php echo webURL?>users/logout" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
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
			<?php echo $this->element('officesidebar');?>
			<div class="content-wrapper">
				<?php echo $this->fetch('content');?>
			</div>
			<?php echo $this->element('footer');?>
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
		</div>
		<?php echo $this->Html->script(array('plugins/jquery/jquery.min.js','plugins/select2/js/select2.full.min.js','plugins/jquery-ui/jquery-ui.min.js','plugins/bootstrap/js/bootstrap.bundle.min.js','plugins/jquery-validation/jquery.validate.min.js','plugins/jquery-validation/additional-methods.min.js','plugins/moment/moment.min.js','plugins/daterangepicker/daterangepicker.js','plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js','plugins/summernote/summernote-bs4.min.js','plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js','adminlte.js','demo.js','custom.js','admin.js','jquery.dataTables.min.js','dataTables.buttons.min.js','buttons.html5.min.js','buttons.print.min.js','buttons.colVis.min.js','jszip.min.js','pdfmake.min.js','vfs_fonts.js'));?>
		<script>
			$(function () {
				//Initialize Select2 Elements
				$('.select2').select2();
				//Date picker
				$('#reservationdate').datetimepicker({
					format: 'L'
				});
				$('#todate').datetimepicker({
					format: 'L'
				});
				$('#fromdate').datetimepicker({
					format: 'L'
				});
			});
		</script>
		<?= $this->Html->scriptBlock(
			'var csrfToken = ' . json_encode($this->request->getAttribute('csrfToken'))
			); ?>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<div class="bhashini-plugin-container"></div>
		<script src="https://translation-plugin.bhashini.co.in/v2/website_translation_utility.js"></script>
	</body>
</html>