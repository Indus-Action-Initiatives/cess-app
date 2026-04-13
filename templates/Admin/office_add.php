<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Manage Offices</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Manage Offices</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="offices form content container mt-4">
				<h3><?= __('Add Office') ?></h3>
				<?= $this->Form->create($office, ['class' => 'needs-validation', 'autocomplete' => 'off', 'novalidate' => true]) ?>
				<div class="form-row">
					<div class="form-group col-md-6">
						<?= $this->Form->control('parent_id', ['options' => [''=>'Select Parent Office']+$parentOffices, 'class' => 'form-control', 'label' => 'Parent Office']) ?>
					</div>
					<div class="form-group col-md-6">
						<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Office Name']) ?>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<?= $this->Form->control('address', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Office Address']) ?>
					</div>
					<div class="form-group col-md-6">
						<?= $this->Form->control('description', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Office Description']) ?>
					</div>
				</div>
				<br><hr><br>
				<div class="form-row">
					<div class="form-group col-md-3">
						<?= $this->Form->control('officer_name', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-3">
						<?= $this->Form->control('officer_designation', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-3">
						<?= $this->Form->control('phone', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-3">
						<?= $this->Form->control('tel', ['class' => 'form-control', 'label' => 'Telephone']) ?>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4">
						<?= $this->Form->control('email', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-4">
						<?= $this->Form->control('state_id', ['options' => [''=>'Select State']+$states,'class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-4">
						<?= $this->Form->control('district_id', ['options' => [], 'empty' => 'Select District', 'class' => 'form-control']) ?>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4">
						<?= $this->Form->control('pincode', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-4">
						<?= $this->Form->control('statecode', ['class' => 'form-control']) ?>
					</div>
					<div class="form-group col-md-4">
						<?= $this->Form->control('password', ['class' => 'form-control']) ?>
					</div>
				</div>
				<div class="form-group text-center mt-4">
					<?= $this->Form->button(__('Save Office'), ['class' => 'btn btn-primary px-4']) ?>
					<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary ml-2']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</section>
<script>
$(document).ready(function () {
	$('#state-id').on('change', function () {
		const stateId = $(this).val();
		const districtDropdown = $('#district-id');
		districtDropdown.empty().append('<option value="">Loading...</option>');

		if (!stateId) {
			districtDropdown.html('<option value="">Select District</option>');
			return;
		}

		$.ajax({
			url: '<?= webURL.'admin/getByState/' ?>'+stateId,
			method: 'GET',
			dataType: 'json',
			success: function (data) {
				districtDropdown.empty().append('<option value="">Select District</option>');
				$.each(data, function (key, value) {
						districtDropdown.append($('<option></option>').attr('value', key).text(value));
				});
			},
			error: function () {
				districtDropdown.html('<option value="">Error loading districts</option>');
			}
		});
	});
});
</script>
