<div class="container-fluid py-4 m-3">
	<h3 class="mb-3 text-primary fw-bold">🧾 Pending Tasks</h3>
	<div class="card shadow-sm rounded-3 mb-4">
		<div class="card-body p-0">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-primary">
					<tr>
						<th>#</th>
						<th>File Name</th>
						<th>Establishment Type</th>
						<th>Assessment Name</th>
						<th>Status</th>
						<th>Due Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!$pendingTasks->isEmpty()): ?>
						<?php $i = 1; foreach ($pendingTasks as $task): ?>
							<tr>
								<td><?= $i++ ?></td>
								<td><?= h($task->file_name) ?></td>
								<td><?= h($task->establishment_type) ?></td>
								<td><?= h($task->assessment_name) ?></td>
								<td>
								<?php
									if($task->flow_id == 1) echo '<span class="badge bg-warning text-dark">Due Registration Fees</span>';
									elseif($task->flow_id == 4) echo '<span class="badge bg-warning text-dark">Due Cess Fees</span>';
								?>
								</td>
								<td><?= $task->due_date ? $task->due_date->format('d-m-Y') : '-' ?></td>
								<td>
								<?php if($task->flow_id == 1){ ?>
									<a href="<?= $this->Url->build(['action' => 'view', base64_encode($task->id), '?' => ['payment' => true]]) ?>" class="btn btn-outline-primary btn-sm">
										Registration Payment
									</a>
								<?php } elseif($task->flow_id == 4){ ?>
									<a href="<?= $this->Url->build(['action' => 'view', base64_encode($task->id), '?' => ['payment' => true]]) ?>" class="btn btn-outline-primary btn-sm">
										Cess Payment
									</a>
								<?php } ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr><td colspan="7" class="text-center text-muted py-3">No pending registrations.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<h3 class="mb-3 text-primary fw-bold">📋 All Labour Cess Projects</h3>
	<div class="card shadow-sm rounded-3">
		<div class="card-body p-0">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>File Name</th>
						<th>Establishment Type</th>
						<th>Assessment Name</th>
						<th>Application Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!$viewTasks->isEmpty()): ?>
						<?php $j = 1; foreach ($viewTasks as $task): ?>
							<tr>
								<td><?= $j++ ?></td>
								<td><?= h($task->file_name) ?></td>
								<td><?= h($task->establishment_type) ?></td>
								<td><?= h($task->assessment_name) ?></td>
								<td>
								<?php
									if ($task->flow_id == 1) {
										echo 'Application Created';
									} elseif ($task->flow_id == 2) {
										echo 'Registration Fee Paid';
									} elseif ($task->flow_id == 3) {
										echo 'Registration Verified';
									} elseif ($task->flow_id == 4) {
										echo 'Cess Assessment';
									} elseif ($task->flow_id == 5) {
										echo 'Cess Fee Paid';
									} elseif ($task->flow_id == 6) {
										echo 'Cess Fee Verified';
									} elseif ($task->flow_id == 7) {
										echo 'Certificate Issued';
									} elseif ($task->flow_id == 8) {
										echo 'Re-Assessment Initiated';
									} elseif ($task->flow_id == 9) {
										echo 'Re-Assessment';
									} elseif ($task->flow_id == 10) {
										echo 'Re-Assessment Fee Paid';
									}  elseif ($task->flow_id == 11) {
										echo 'Re-Assessment Fee Verified';
									}
								?>
								</td>
								<td>
									<a href="<?= $this->Url->build(['action' => 'view', base64_encode($task->id)]) ?>" class="btn btn-outline-info btn-sm">View</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr><td colspan="7" class="text-center text-muted py-3">No projects found.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
.table-primary th {
	background-color: #007bff !important;
	color: white !important;
}
</style>