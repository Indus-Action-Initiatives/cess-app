<?= $this->Form->create(null, ['type' => 'file', 'class' => 'mt-4']) ?>
<table class="table table-bordered mt-3">
	<thead>
		<tr>
			<th>#</th>
			<th>Document Type</th>
			<th>Description</th>
			<th>Upload File </th>
		</tr>
	</thead>
	<tbody>
		<?php if ($registrationType === 'individual'): ?>
			<tr class="required-row">
				<td>1</td>
				<td>Photo Identity Proof <span class="required">*</span></td>
				<td>
					<?= $this->Form->control('desc_idproof', [
						'label' => false,
						'class' => 'form-control',
						'required' => true,
						'placeholder' => 'Enter ID proof description'
					]) ?>
				</td>
				<td>
					<?= $this->Form->control('file_idproof', [
						'type' => 'file',
						'label' => false,
						'class' => 'form-control',
						'required' => true
					]) ?>
				</td>
			</tr>
			<tr>
				<td>2</td>
				<td>Any Other Document</td>
				<td>
					<?= $this->Form->control('desc_other', [
						'label' => false,
						'class' => 'form-control',
						'placeholder' => 'Enter document description'
					]) ?>
				</td>
				<td>
					<?= $this->Form->control('file_other', [
						'type' => 'file',
						'label' => false,
						'class' => 'form-control'
					]) ?>
				</td>
			</tr>
		<?php else: ?>
			<!-- Include full company document upload table -->
			<?= $this->element('register/step3_full_form'); ?>
		<?php endif; ?>
	</tbody>
</table>
<div class="text-end mt-3">
	<?= $this->Form->button('Submit', ['class' => 'btn btn-primary px-4']) ?>
</div>
<?= $this->Form->end() ?>
<style>
	.required {
		color: red;
	}
	.table {
		background-color: #fff;
	}
	.form-control {
		border-radius: 6px;
	}
	.required-row td {
		background-color: #fff9f9;
	}
</style>