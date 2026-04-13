<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Helpdesk Tickets</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h3><?= __('Helpdesk Tickets') ?></h3>
		</div>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Ticket No</th>
					<th>User</th>
					<th>Email</th>
					<th>Subject</th>
					<th>Status</th>
					<th>Created</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tickets as $t): ?>
					<tr>
						<td><?= $t->ticket_no ?></td>
						<td><?= h($t->helpdesk_user->name) ?></td>
						<td><?= h($t->helpdesk_user->email) ?></td>
						<td><?= h($t->subject) ?></td>
						<td>
						<span class="badge badge-<?= $t->status === 'Closed' ? 'success' : 'warning' ?>">
						<?= h($t->status) ?>
						</span>
						</td>
						<td><?= $t->created->format('d-m-Y') ?></td>
						<td>
						<a href="<?= $this->Url->build(['action'=>'ticketView', $t->id]) ?>"
						class="btn btn-sm btn-primary">
						View
						</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>