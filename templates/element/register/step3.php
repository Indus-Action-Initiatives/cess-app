<?= $this->Form->create(null, ['type' => 'file', 'class' => 'mt-4']) ?>
<table class="table table-bordered table-striped">
	<thead class="table-dark">
		<tr>
			<th>#</th>
			<th>Type</th>
			<th>Attachment Description</th>
			<th>Upload File</th>
		</tr>
	</thead>
	<tbody>
		<tr class="required-row common-row">
			<td>1</td>
			<td>Photo Identity Proof <span class="required">*</span></td>
			<td><?= $this->Form->control('desc_idproof', ['label' => false, 'class' => 'form-control desc-required']) ?></td>
			<td><?= $this->Form->control('file_idproof', ['type' => 'file', 'label' => false, 'class' => 'form-control file-required']) ?></td>
		</tr>
		<tr class="company-only">
			<td>2</td>
			<td>Company Registration No <span class="required">*</span></td>
			<td><?= $this->Form->control('desc_company', ['label' => false, 'class' => 'form-control desc-required']) ?></td>
			<td><?= $this->Form->control('file_company', ['type' => 'file', 'label' => false, 'class' => 'form-control file-required']) ?></td>
		</tr>
		<tr class="required-row company-only">
			<td>3</td>
			<td>GST <span class="required">*</span></td>
			<td><?= $this->Form->control('desc_gst', ['label' => false, 'class' => 'form-control desc-required']) ?></td>
			<td><?= $this->Form->control('file_gst', ['type' => 'file', 'label' => false, 'class' => 'form-control file-required']) ?></td>
		</tr>
		<tr class="required-row company-only">
			<td>4</td>
			<td>PAN Card <span class="required">*</span></td>
			<td><?= $this->Form->control('desc_pan', ['label' => false, 'class' => 'form-control desc-required']) ?></td>
			<td><?= $this->Form->control('file_pan', ['type' => 'file', 'label' => false, 'class' => 'form-control file-required']) ?></td>
		</tr>
		<tr class="common-row">
			<td>5</td>
			<td>Any Other Document</td>
			<td><?= $this->Form->control('desc_other', ['label' => false, 'required' => false, 'class' => 'form-control']) ?></td>
			<td><?= $this->Form->control('file_other', ['type' => 'file', 'label' => false, 'required' => false, 'class' => 'form-control']) ?></td>
		</tr>
	</tbody>
</table>
<div class="d-flex justify-content-between">
	<?= $this->Html->link('← Back', ['action' => 'register', 2], ['class' => 'btn btn-secondary']) ?>
	<?= $this->Form->button('Complete ✔', ['class' => 'btn btn-success px-4', 'id' => 'submit-btn']) ?>
</div>
<?= $this->Form->end() ?>
<script>
$(document).ready(function() {
	const registrationType = "<?= h($registrationType ?? '') ?>".toLowerCase();
	// 1️⃣ Show/Hide fields based on registration type
	if (registrationType === 'individual') {
		$('.company-only').hide().find('input').prop('required', false);
	} else {
		$('.company-only').show().find('input').prop('required', true);
	}
	// 2️⃣ Validation helpers
	function showInvalid($el, msg) {
		$el.addClass('is-invalid').removeClass('is-valid');
		$el.next('.invalid-feedback').remove();
		$el.after('<div class="invalid-feedback">' + msg + '</div>');
	}
	function showValid($el) {
		$el.removeClass('is-invalid').addClass('is-valid');
		$el.next('.invalid-feedback').remove();
	}
	// 3️⃣ Validate individual field
	function validateField($el, type) {
		const val = $el.val().trim();
		const label = $el.closest('tr').find('td:nth-child(2)').text().trim();
		if (val === '') {
			showInvalid($el, `${label} is required.`);
			return false;
		} else {
			showValid($el);
			return true;
		}
	}
	// 4️⃣ Real-time validation
	$('.desc-required').on('keyup blur', function() {
		validateField($(this), 'text');
	});
	$('.file-required').on('change blur', function() {
		validateField($(this), 'file');
	});
	// 5️⃣ Form submit validation guard
	$('form').on('submit', function(e) {
		let valid = true;
		const visibleRows = registrationType === 'individual'
			? $('.common-row')
			: $('.common-row, .company-only');

		visibleRows.find('.desc-required, .file-required').each(function() {
			if (!validateField($(this), $(this).attr('type'))) valid = false;
		});
		if (!valid) {
			e.preventDefault();
			alert('⚠️ Please fill all required fields and upload the mandatory documents.');
		}
	});
});
</script>
<style>
.required {
	color: red;
}
.table {
	background-color: #fff;
	font-size: 0.95rem;
}
.table th {
	white-space: nowrap;
}
.is-invalid {
	border-color: #dc3545 !important;
}
.is-valid {
	border-color: #198754 !important;
}
.invalid-feedback {
	color: #dc3545;
	font-size: 0.875em;
}
</style>