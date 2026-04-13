<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">District Wise Data</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">District Wise Data</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<h3 class="mb-4">Projects under District: <strong><?= h($district->name) ?></strong></h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th>File No.</th>
							<th>Date</th>
							<th>Assessment Name</th>
							<th>Estb. Type</th>
							<th>Status</th>
							<th width="120">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($projects as $p):
							if ($p->flow_id == 1) {
								$status = 'Application Created';
							} elseif ($p->flow_id == 2) {
								$status = 'Registration Payment';
							} elseif ($p->flow_id == 3) {
								$status = 'Registration Verified';
							} elseif ($p->flow_id == 4) {
								$status = 'Cess Assessment';
							} elseif ($p->flow_id == 5) {
								$status = 'Cess Payment';
							} elseif ($p->flow_id == 6) {
								$status = 'Cess Verified';
							} elseif ($p->flow_id == 7) {
								$status = 'Certificate Issued';
							}
							?>
							<tr>
								<td><?= $i ?></td>
								<td><?= h($p->file_name) ?></td>
								<td><?= $p->created_at->format('d-M-Y') ?></td>
								<td><?= h($p->assessment_name) ?></td>
								<td><?= h($p->establishment_type) ?></td>
								<td><?= $status ?></td>
								<td>
									<a href="<?= $this->Url->build(['action' => 'view', $p->id]) ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View</a>
								</td>
							</tr>
						<?php $i++; endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="paginator">
				<ul class="pagination">
					<?= $this->Paginator->first('<< First') ?>
					<?= $this->Paginator->prev('< Previous') ?>
					<?= $this->Paginator->numbers() ?>
					<?= $this->Paginator->next('Next >') ?>
					<?= $this->Paginator->last('Last >>') ?>
				</ul>
			</div>
		</div>
	</div>
</section>