<aside class="main-sidebar elevation-4" style="background-color: #1d3175; color: white; height: 100vh;">
	<a href="javascript:void(0);" class="brand-link">
		<span class="brand-text"><b style="color:white;">Labour Cess</b></span>
	</a>
	<div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo webURL?>admin/dashboard" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt" style="color:white;"></i> <p style="color:white;">Dashboard</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo webURL?>admin/labour_cess" class="nav-link">
						<i class="nav-icon fas fa-columns" style="color:white;"></i> <p style="color:white;">Labour Cess</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo webURL?>admin/task_list" class="nav-link">
						<i class="nav-icon fas fa-columns" style="color:white;"></i> <p style="color:white;">Task List</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-columns" style="color:white;"></i> <p style="color:white;">Manage Offices <i class="right fas fa-angle-left"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo webURL?>admin/office_index" class="nav-link">
								<i class="far fa-circle nav-icon" style="color:white;"></i> <p style="color:white;">List Office</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo webURL?>admin/office_add" class="nav-link">
								<i class="far fa-circle nav-icon" style="color:white;"></i> <p style="color:white;">Add Office</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?php echo webURL?>admin/tickets" class="nav-link">
						<i class="nav-icon fas fa-envelope-open-text" style="color:white;"></i> <p style="color:white;">Task List</p>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		var currentUrl = window.location.href;
		$('.nav-item a').each(function() {
			if ($(this).attr('href') === currentUrl) {
				$(this).addClass('active');
				$(this).parents('.nav-item').addClass('menu-is-opening menu-open');
			}
		});
	});
</script>