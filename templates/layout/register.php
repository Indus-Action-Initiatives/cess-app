<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
		<title>User Registration | BOCW - Labour Cess Portal</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php echo $this->Html->meta('icon'); ?>
		<?Php echo $this->Html->css(array('plugins/fontawesome-free/css/all.min.css', 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css', 'plugins/icheck-bootstrap/icheck-bootstrap.min.css', 'plugins/jqvmap/jqvmap.min.css', 'adminlte.min.css', 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css', 'plugins/daterangepicker/daterangepicker.css', 'plugins/summernote/summernote-bs4.min.css', 'plugins/select2/css/select2.min.css', 'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css', 'jquery.dataTables.min.css')); ?>
		<script type="text/javascript">var webURL = '<?php echo webURL; ?>'; </script>
		<style>
			.login-page { background-color: #E0E1E2; }
			.header-wrapper {
				border-bottom: 1px solid #d0d0d0;
				background: #fff;
				width: 100%;
			}
			.navbar-brand img, .header-right img {
				max-width: 100%;
				height: auto;
				vertical-align: middle;
			}
			.logo {
				background: url(../img/emblem-dark.png) no-repeat 3px 0;
				float: left;
				font-size: 160%;
				line-height: 105%;
				min-height: 103px;
				padding: 14px 0 0 78px;
				text-transform: uppercase;
			}
			.logo a {
				display: block;
				color: #000;
				text-align: left;
			}
			.logo a strong {
				font-weight: 600;
				display: block;
				font-size: 80%;
			}
			.logo a span {
				display: block;
				font-weight: 900;
				font-size: 110%;
			}
			.header-container {
				padding: 8px 0px 6px;
			}
			.shadow-lg {
				box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.3) !important;
			}
			footer {
				background: #ce7328;
				color: #fff;
				padding: 15px 0;
				text-align: center;
				font-size: 16px;
				/*position: fixed;*/
				bottom: 0;
				width: 100%;
				border-top: 2px solid #ffffff;
			}
			footer a {
				color: #2743a3;
				text-decoration: none;
				font-weight: bold;
				/*font-size: 16px;*/
			}
			footer a:hover {
				text-decoration: underline;
			}
			.chatbot-btn {
				position: fixed;
				bottom: 125px;
				right: 25px;
				background: #007bff;
				color: #fff;
				border-radius: 50%;
				width: 60px;
				height: 60px;
				display: flex;
				justify-content: center;
				align-items: center;
				cursor: pointer;
				box-shadow: 0 4px 8px rgba(0,0,0,0.3);
				font-size: 28px;
				z-index: 999;
			}
			.chatbot-btn:hover {
				background: #0056b3;
			}
			.chatbot-popup {
				position: fixed;
				bottom: 125px;
				right: 25px;
				width: 350px;
				max-height: 500px;
				background: #fff;
				border-radius: 10px;
				box-shadow: 0 0 15px rgba(0,0,0,0.2);
				display: none;
				flex-direction: column;
				overflow: hidden;
				z-index: 1000;
			}
			.chat-header {
				background: #007bff;
				color: #fff;
				padding: 10px;
				font-weight: bold;
				display: flex;
				justify-content: space-between;
				align-items: center;
			}
			.chat-header span {
				cursor: pointer;
				font-size: 20px;
			}
			.chat-body {
				flex: 1;
				overflow-y: auto;
				padding: 10px;
			}
			.message {
				margin-bottom: 10px;
				clear: both;
			}
			.bot-msg {
				background: #e9ecef;
				padding: 8px 12px;
				border-radius: 15px;
				display: inline-block;
				max-width: 80%;
			}
			.user-msg {
				background: #007bff;
				color: #fff;
				padding: 8px 12px;
				border-radius: 15px;
				display: inline-block;
				max-width: 80%;
				float: right;
			}
			.chat-footer {
				border-top: 1px solid #ddd;
				padding: 8px;
				display: flex;
			}
			.chat-footer input {
				flex: 1;
				border: none;
				padding: 8px;
				border-radius: 20px;
				background: #f1f1f1;
				outline: none;
			}
			.chat-footer button {
				background: #007bff;
				border: none;
				color: white;
				border-radius: 50%;
				width: 38px;
				height: 38px;
				margin-left: 8px;
			}
			header.header-wrapper .mid-side {
				padding: 5px 50px;
			}
			.top-nav {
				background-color: #ef8b3e;
				padding: 5px;
				/*height: 25px;*/
				width: 100%;
				color: #ffffff;
			}
		</style>
		<?php echo $this->Html->script(array('plugins/jquery/jquery.min.js', 'plugins/jquery-ui/jquery-ui.min.js')); ?>
	</head>
	<body class="">
		<section class="top-nav d-flex">
			<div class="col">
				<span>Ministry of Labour & Employment | Government of India</span>
			</div>
			<div class="col text-right">
				<span>
					<i class="fa-brands fa-facebook"></i>
				</span>
				<span>
					<i class="fa-brands fa-instagram"></i>
				</span>
				<span>
					<i class="fa-brands fa-x-twitter"></i>
				</span>
				<span>
					<i class="fa-brands fa-linkedin"></i>
				</span>
			</div>
		</section>
		<header class="header-wrapper">
			<div class="mid-side">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-3 col-md-5 site-logo p-0">
							<div class="d-flex">
								<img src="<?php echo webURL; ?>img/emblem-dark.png" alt="National Emblem" class="emblem mr-3">
								<div class="govt-text">
									<p class="hindi mb-0">श्रम एवं रोजगार मंत्रालय</p>
									<p class="english mb-0">GOVERNMENT OF INDIA</p>
									<h5 class="ministry mb-0">MINISTRY OF LABOUR &amp; EMPLOYMENT</h5>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-7 top-logo text-center p-0">
							<div class="text-center p-3">
								<!-- <img src="<?= $this->Url->image("bihar.jpg"); ?>" alt="State Logo" style="width:150px; height:auto; margin-right:20px;" class="state-logo mr-3"> -->
								<p>[State Logo]</p>
								<h6 class="text-muted mb-0" style="color: #d66a6aff;">Department of Labour, Government Of [State Name]</h6>
								<h5 class="font-weight-bold" style="color: #d66a6aff;">Building and Other Construction Workers Welfare Board</h5>
							</div>
						</div>
						<div class="col-lg-3 col-md-12 top-logo p-0" style="float: right; text-align: right;">
							<!-- <a href="https://www.g20.org/en/" target="_blank" class="mx-2">
								<img src="img/g20_2.png" alt="G20" class="header-logo">
								</a> -->
							<a href="https://amritmahotsav.nic.in/" target="_blank" class="mx-2">
								<img src="<?php echo webURL; ?>img/azadi_0.jpg" alt="Azadi Ka Amrit Mahotsav" class="header-logo">
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="wrapper">
			<div class="content-wrapper" style="background: url('<?= $this->Url->image("india-gate-mornings.jpg"); ?>') no-repeat center center / cover;
			width: 100%;
			padding: 10px 100px;
			margin: 0;
			padding-top: 40px;">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<footer>
			<div class="container">
				<p class="mb-1">© <?= date('Y') ?> Department of Labour, Government of [State Name]. All Rights Reserved.</p>
				<p class="mb-0">Designed & Developed by <a href="#">Ministry of Labour & Employment</a></p>
			</div>
		</footer>
		<?php echo $this->Html->script(array('plugins/select2/js/select2.full.min.js', 'plugins/jquery-ui/jquery-ui.min.js', 'plugins/bootstrap/js/bootstrap.bundle.min.js', 'plugins/jquery-validation/jquery.validate.min.js', 'plugins/jquery-validation/additional-methods.min.js', 'plugins/moment/moment.min.js', 'plugins/daterangepicker/daterangepicker.js', 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', 'plugins/summernote/summernote-bs4.min.js', 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js', 'adminlte.js', 'demo.js', 'custom.js', 'admin.js', 'jquery.dataTables.min.js', 'dataTables.buttons.min.js', 'buttons.html5.min.js', 'buttons.print.min.js', 'buttons.colVis.min.js', 'jszip.min.js', 'pdfmake.min.js', 'vfs_fonts.js')); ?>
		<script>
			$(function() {
				$('.select2').select2();
				$('#reservationdate').datetimepicker({
					format: 'L'
				});
				$('#todate').datetimepicker({
					format: 'L'
				});
				$('#fromdate').datetimepicker({
					format: 'L'
				});
			})
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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			<?php
				// ✅ Fetch flash messages manually
				$messages = $this->getRequest()->getSession()->read('Flash.flash') ?? [];
				$successMessage = '';
				$errorMessage = '';
				foreach ($messages as $msg) {
					if ($msg['element'] === 'flash/success') {
						$successMessage = $msg['message'];
					} elseif ($msg['element'] === 'flash/error') {
						$errorMessage = $msg['message'];
					}
				}
				// ✅ Check if final step completed
				$registrationCompleted = $this->get('registrationCompleted') ?? false;
			?>
			<?php if (!empty($successMessage) && $registrationCompleted): ?>
				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: <?= json_encode(strip_tags($successMessage)) ?>,
					showConfirmButton: true,
					confirmButtonText: 'OK',
					timer: 3000,
					timerProgressBar: true
				}).then(() => {
					// ✅ Redirect to dashboard or login after success
					window.location.href = '<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>';
				});
			<?php elseif (!empty($errorMessage)): ?>
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: <?= json_encode(strip_tags($errorMessage)) ?>,
					confirmButtonColor: '#d33'
				});
			<?php endif; ?>
		</script>
	</body>
</html>