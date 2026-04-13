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
		<div class="card shadow-sm">
			<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Manage District Mapping</h5>
				<?= $this->Html->link('← Back to Offices', ['action' => 'officeIndex'], ['class' => 'btn btn-warning btn-sm']) ?>
			</div>
			<div class="card-body">
				<h6 class="mb-3 text-secondary">
					<strong>Office:</strong> <?= h($office->name) ?><br>
					<strong>State:</strong> <?= h($office->state->name ?? 'N/A') ?><br>
					<strong>Located in:</strong> <?= h($office->district->name ?? 'N/A') ?>
				</h6>
				<?= $this->Form->create($office, ['class' => 'mt-3']) ?>
				<?php
					// Get preselected districts
					$selected = $office->working_districts
						? collection($office->working_districts)->extract('id')->toList()
						: [];
				?>
				<div class="mb-3">
					<label class="font-weight-bold mb-2">Select Working Districts</label>
					<div class="d-flex justify-content-between mb-2">
						<button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">Select All</button>
						<button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">Deselect All</button>
					</div>
					<div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
						<?php foreach ($districts as $id => $name): ?>
							<div class="form-check">
								<?= $this->Form->checkbox('district_ids[]', [
									'value' => $id,
									'checked' => in_array($id, $selected),
									'id' => 'district-' . $id,
									'class' => 'form-check-input'
								]) ?>
								<label class="form-check-label" for="district-<?= $id ?>">
									<?= h($name) ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="mt-3">
					<?= $this->Form->button(__('Save Mapping'), ['class' => 'btn btn-success']) ?>
					<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary ml-2']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const selectAll = document.getElementById('selectAllBtn');
	const deselectAll = document.getElementById('deselectAllBtn');
	const checkboxes = document.querySelectorAll('input[name="district_ids[]"]');

	selectAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = true));
	deselectAll.addEventListener('click', () => checkboxes.forEach(cb => cb.checked = false));
});
</script>