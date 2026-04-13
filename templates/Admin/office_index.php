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
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h3><?= __('Offices List') ?></h3>
			<?= $this->Html->link(__('Add Office'), ['action' => 'officeAdd'], ['class' => 'btn btn-primary']) ?>
		</div>
		<div class="mb-3">
			<?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
				<div class="form-group mr-2">
					<?= $this->Form->control('search', [
						'label' => false,
						'value' => $search,
						'placeholder' => 'Search by name, email, phone...',
						'class' => 'form-control'
					]) ?>
				</div>
				<?= $this->Form->button(__('Search'), ['class' => 'btn btn-secondary']) ?>
			<?= $this->Form->end() ?>
		</div>
		<table class="table table-bordered table-hover table-sm">
			<thead class="thead-light">
				<tr>
					<th><?= $this->Paginator->sort('id', 'ID') ?></th>
					<th><?= $this->Paginator->sort('name', 'Office Name') ?></th>
					<th><?= __('Officer Name') ?></th>
					<th><?= $this->Paginator->sort('email', 'Email') ?></th>
					<th><?= $this->Paginator->sort('phone', 'Phone') ?></th>
					<th><?= __('State') ?></th>
					<th><?= __('District') ?></th>
					<th class="text-center"><?= __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($offices as $office): ?>
					<tr>
						<td><?= h($office->id) ?></td>
						<td><?= h($office->name) ?></td>
						<td><?= h($office->officer_name) ?></td>
						<td><?= h($office->email) ?></td>
						<td><?= h($office->phone) ?></td>
						<td><?= $office->state->name ?? '' ?></td>
						<td><?= $office->district->name ?? '' ?></td>
						<td class="text-center">
							<?= $this->Html->link(__('View'), ['action' => 'view', $office->id], ['class' => 'btn btn-sm btn-info']) ?>
							<?= $this->Html->link(__('Edit'), ['action' => 'edit', $office->id], ['class' => 'btn btn-sm btn-warning']) ?>
							<?= $this->Html->link(__('Mapping'), ['action' => 'officeMapping', $office->id], ['class' => 'btn btn-sm btn-success']) ?>
							<button class="btn btn-sm btn-warning change-password-btn" data-toggle="modal" data-target="#changePasswordModal" data-user-id="<?= $office->user_id ?>" data-user-name="<?= h($office->officer_name) ?>">
								<i class="fa fa-key"></i> Change Password
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="d-flex justify-content-between align-items-center">
			<div><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></div>
			<ul class="pagination pagination-sm mb-0">
				<?= $this->Paginator->first('<<') ?>
				<?= $this->Paginator->prev('<') ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next('>') ?>
				<?= $this->Paginator->last('>>') ?>
			</ul>
		</div>
	</div>
</section>
<div class="modal fade" id="changePasswordModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<?= $this->Form->create(null, [
				'url' => webURL.'admin/changeOfficePassword',
				'id' => 'changePasswordForm'
			]) ?>
			<div class="modal-header bg-warning">
				<h5 class="modal-title">Change Password</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="user_id" id="cp_user_id">
				<div class="form-group">
					<label>Officer</label>
					<input type="text" class="form-control" id="cp_user_name" readonly>
				</div>
				<div class="form-group">
					<?= $this->Form->control('new_password', [
						'type' => 'password',
						'label' => 'New Password',
						'class' => 'form-control',
						'required' => true
					]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('confirm_password', [
						'type' => 'password',
						'label' => 'Confirm Password',
						'class' => 'form-control',
						'required' => true
					]) ?>
				</div>
			</div>
			<div class="modal-footer">
				<?= $this->Form->button('Update Password', ['class' => 'btn btn-success']) ?>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
$(document).on('click', '.change-password-btn', function () {
	const userId = $(this).data('user-id');
	const userName = $(this).data('user-name');
	$('#cp_user_id').val(userId);
	$('#cp_user_name').val(userName);
});
</script>