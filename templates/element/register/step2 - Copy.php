<?= $this->Form->create(null, ['class' => 'mt-4']) ?>

<h5 class="mb-3"><b>Address Information</b></h5>

<div class="form-row">
	<div class="form-group col-md-6">
		<?= $this->Form->control('state_id', [
			'label' => 'State <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'options' => $states,
			'empty' => 'Select State',
			'required' => true,
			'id' => 'state-id'
		]) ?>
	</div>

	<div class="form-group col-md-6">
		<?= $this->Form->control('district_id', [
			'label' => 'District <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'options' => [],
			'empty' => 'Select District',
			'required' => true,
			'id' => 'district-id'
		]) ?>
	</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6">
		<?= $this->Form->control('city', [
			'label' => 'City <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'required' => true,
		]) ?>
	</div>

	<div class="form-group col-md-6">
		<?= $this->Form->control('communication_address', [
			'label' => 'Communication Address <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'required' => true,
		]) ?>
	</div>
</div>

<h5 class="mb-3"><b>Identity Information</b></h5>
<p>Please provide the company's legal information below. Fill the form carefully:</p>

<div class="form-row" id="other-info-section">
	<div class="form-group col-md-4">
		<?= $this->Form->control('contact_person_name', [
			'label' => 'Contact Person Name <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'required' => true,
		]) ?>
	</div>

	<div class="form-group col-md-4 company-only">
		<?= $this->Form->control('gst_no', [
			'label' => 'GST No <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'id' => 'gst_no',
			'maxlength' => 15,
			'required' => true,
		]) ?>
	</div>

	<div class="form-group col-md-4 company-only">
		<?= $this->Form->control('firm_registration_no', [
			'label' => 'Firm Registration No <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'id' => 'firm_registration_no',
			'required' => true,
		]) ?>
	</div>

	<div class="form-group col-md-4">
		<?= $this->Form->control('identity_proof_type', [
			'label' => 'Type of Identity Proof <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'required' => true,
			'options' => [
				'0' => 'Aadhar Number',
				'1' => 'PAN No',
				'2' => 'Voter ID'
			],
			'empty' => 'Select Type of Identity Proof',
		]) ?>
	</div>

	<div class="form-group col-md-4">
		<?= $this->Form->control('identity_proof_no', [
			'label' => 'Identity Proof No <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'required' => true,
		]) ?>
	</div>

	<div class="form-group col-md-4 company-only">
		<?= $this->Form->control('pan_no', [
			'label' => 'PAN No <span class="required">*</span>',
			'escape' => false,
			'class' => 'form-control',
			'id' => 'pan_no',
			'maxlength' => 10,
			'required' => true,
		]) ?>
	</div>
</div>

<div class="d-flex justify-content-between">
	<?= $this->Html->link('← Back', ['action' => 'register', 1], ['class' => 'btn btn-secondary']) ?>
	<?= $this->Form->button('Next →', ['class' => 'btn btn-primary px-4']) ?>
</div>

<?= $this->Form->end() ?>


<!-- ✅ Script Section -->
<script>
$(document).ready(function() {

	// 1️⃣ Populate district dropdown dynamically
  const stateSelect = $('#state-id');
	const districtSelect = $('#district-id');
 /* 
	stateSelect.on('change', function() {
		const stateId = $(this).val();
		districtSelect.html('<option value="">Loading...</option>');

		if (stateId) {
			fetch(`<?= $this->Url->build(['controller' => 'Register', 'action' => 'getDistrictsByState']) ?>/${stateId}`)
				.then(res => res.json())
				.then(data => {
					districtSelect.html('<option value="">Select District</option>');
					$.each(data.districts, function(id, name) {
						districtSelect.append(`<option value="${id}">${name}</option>`);
					});
				})
				.catch(() => {
					districtSelect.html('<option value="">Error loading districts</option>');
				});
		} else {
			districtSelect.html('<option value="">Select District</option>');
		}
	});
 */
stateSelect.on('change', function() {
	const stateId = $(this).val();
	districtSelect.html('<option>Loading...</option>');

	if (stateId) {
		$.ajax({
			url: "<?= $this->Url->build('/register/getDistrictsByState') ?>/" + stateId,
			type: "GET",
			dataType: "json",
			success: function(response) {
				const dist=response.response.districts;
				console.log(dist);
				districtSelect.html('<option value="">Select District</option>');
				// ✅ Handle plain object
				if (dist) {
					$.each(dist, function(id, name) {
						districtSelect.append(`<option value="${id}">${name}</option>`);
					});
				} else {
					districtSelect.html('<option value="">No districts found</option>');
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", error);
				districtSelect.html('<option value="">Error loading districts</option>');
			}
		});
	} else {
		districtSelect.html('<option value="">Select District</option>');
	}
});


	// 2️⃣ Registration type from Step 1 (server)
	const registrationType = "<?= h($registrationType ?? '') ?>".toLowerCase();

	if (registrationType === 'individual') {
		$('.company-only').hide().find('input, select').prop('required', false);
	} else {
		$('.company-only').show().find('input, select').prop('required', true);
	}

	// 3️⃣ Regex patterns
	const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
	const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;

	// 4️⃣ UI helpers
	function showInvalid($el, msg) {
		$el.addClass('is-invalid').removeClass('is-valid');
		$el.next('.invalid-feedback').remove();
		$el.after('<div class="invalid-feedback">' + msg + '</div>');
	}

	function showValid($el) {
		$el.removeClass('is-invalid').addClass('is-valid');
		$el.next('.invalid-feedback').remove();
	}

	// 5️⃣ Field validator
	function validateField(selector, regex, emptyMsg, invalidMsg) {
		const $field = $(selector);
		if (!$field.is(':visible')) return true;
		const val = $field.val().trim().toUpperCase();
		$field.val(val);
		if (val === '') {
			showInvalid($field, emptyMsg);
			return false;
		} else if (!regex.test(val)) {
			showInvalid($field, invalidMsg);
			return false;
		} else {
			showValid($field);
			return true;
		}
	}

	// 6️⃣ Real-time validation
	$('#pan_no').on('keyup blur', function() {
		validateField('#pan_no', panRegex, 'PAN number is required.', 'Invalid PAN format (e.g., ABCDE1234F).');
	});
	$('#gst_no').on('keyup blur', function() {
		validateField('#gst_no', gstRegex, 'GST number is required.', 'Invalid GST format (e.g., 22ABCDE1234F1Z5).');
	});

	// 7️⃣ Form submission validation
	$('form').on('submit', function(e) {
		let valid = true;
		if (registrationType !== 'individual') {
			if (!validateField('#pan_no', panRegex, 'PAN number is required.', 'Invalid PAN format.')) valid = false;
			if (!validateField('#gst_no', gstRegex, 'GST number is required.', 'Invalid GST format.')) valid = false;
		}
		if (!valid) e.preventDefault();
	});
});
</script>

<!-- ✅ Styles -->
<style>
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
