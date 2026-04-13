<style>
	.stat-card {
		border-radius: 16px;
		padding: 25px;
		color: #fff;
		transition: 0.3s ease;
		cursor: pointer;
		box-shadow: 0 8px 20px rgba(0,0,0,0.15);
	}
	.stat-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 12px 28px rgba(0,0,0,0.25);
	}
	.stat-icon {
		font-size: 42px;
		opacity: 0.3;
		position: absolute;
		top: 20px;
		right: 20px;
	}
	.stat-title {
		font-size: 20px;
		font-weight: bold;
		margin-bottom: 10px;
	}
	.stat-number {
		font-size: 32px;
		font-weight: bold;
		margin-bottom: 15px;
	}
	.view-btn {
		background: rgba(255,255,255,0.2);
		padding: 7px 15px;
		border-radius: 8px;
		color: #fff;
		font-weight: bold;
		text-decoration: none;
		transition: 0.3s;
	}
	.view-btn:hover {
		background: rgba(255,255,255,0.35);
		text-decoration: none;
		color: #fff;
	}
	.bx-color-1{ background: linear-gradient(135deg, #9C27B0, #0056b3); }
	.bx-color-2{ background: linear-gradient(135deg, #4CAF50, #0056b3); }
	.bx-color-3{ background: linear-gradient(135deg, #E91E63, #0056b3); }
</style>
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h3><?= $globalStats['total_projects'] ?? 0 ?></h3>
						<p>Total Projects</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo webURL?>admin/labourCess" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="small-box bg-success">
					<div class="inner">
						<h3><?= $globalStats['total_approved'] ?? 0 ?></h3>
						<p>Approved</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo webURL?>admin/labourCess" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="small-box bg-warning">
					<div class="inner">
						<h3><?= $globalStats['total_pending'] ?? 0 ?></h3>
						<p>Pending</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo webURL?>admin/labourCess" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="small-box bg-danger">
					<div class="inner">
						<h3><?= $globalStats['total_rejected'] ?? 0 ?></h3>
						<p>Rejected</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo webURL?>admin/rejected" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-4">
				<div class="small-box bg-success">
					<div class="inner">
						<h3>₹ <?= number_format($globalStats['approved_amount'] ?? 0, 2) ?></h3>
						<p>Total Cess Amount</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo webURL?>admin/cess" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<?php
				$class = ['bx-color-1', 'bx-color-2', 'bx-color-3'];
				$i = 0;
			?>
			<?php foreach ($districtStats as $d):
				$cls = $class[$i % 3];
				?>
			<div class="col-md-4 mb-4 position-relative">
				<div class="stat-card <?=$cls?>">
					<i class="fa fa-map-marker-alt stat-icon"></i>
					<div class="stat-title"><?= h($d['name']) ?></div>
					<div class="stat-number"><?= $d['total_projects'] ?> <small>Projects</small></div>
					<span><i class="fa fa-check-circle"></i> &nbsp; Approved: <strong><?= $d['approved'] ?></strong></span>
					<span class="pl-5"><i class="fa fa-times-circle"></i> &nbsp; Rejected: <strong><?= $d['rejected'] ?></strong></span><br>
					<span><i class="fa fa-hourglass-half"></i> &nbsp; In-Process: <strong><?= $d['in_process'] ?></strong></span>
					<span class="pl-5"><i class="fa fa-rupee-sign"></i> &nbsp; Amount : <strong><?= number_format($d['approved_amount'], 2) ?></strong></span>
					<a href="<?= $this->Url->build(['controller'=>'Admin','action'=>'districtWiseData',base64_encode($d['id'])]) ?>" class="view-btn mt-3 d-inline-block w-100 text-center">View Details &nbsp;<span class="text-right">→</span></a>
				</div>
			</div>
			<?php
			$i++;
			endforeach; ?>
		</div>
	</div>
</section>