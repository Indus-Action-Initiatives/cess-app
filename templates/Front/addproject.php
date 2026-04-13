<style>
.locked-card {
	background-color: #f9f9f9;
	opacity: 0.8;
}
</style>
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Add Labour Cess Project</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>front/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Add Project</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid mt-4">
		<!-- STEP 1 -->
		<div class="card mb-4" id="step1Card">
			<div class="card-header bg-primary text-white">Step 1: Basic Information</div>
			<div class="card-body">
				<p class="mb-4">All fields are mandatory(*). Please fill carefully.</p>
				<form id="step1Form">
					<div class="form-row">
						<div class="form-group col-md-6">
							<?= $this->Form->control('department_id', [
								'label' => 'Department <span class="required">*</span>',
								'escape' => false,
								'class' => 'form-control',
								'options' => $districts,
								'empty' => 'Select Department',
								'required' => true,
								'id' => 'department-id'
							]) ?>
						</div>
						<div class="form-group col-md-6">
							<label>Construction Type *</label>
							<select name="establishment_type" class="form-control" required>
								<option value="">Select Construction Type</option>
								<option value="Complete Construction">Complete Construction</option>
								<option value="Partial Construction">Partial Construction</option>
							</select>
						</div>
						<div class="form-group col-md-12">
							<label>Project Name *</label>
							<input type="text" name="assessment_name" class="form-control" placeholder="Enter Project Title" required>
						</div>
						<div class="form-group col-md-12">
							<label>Project Description</label>
							<textarea name="description" class="form-control" placeholder="Enter Description (Optional)"></textarea>
						</div>
					</div>
					<button type="button" class="btn btn-primary float-right" id="saveStep1">Save as Draft</button>
				</form>
			</div>
		</div>
		<!-- STEP 2 -->
		<div class="card mb-4 d-none" id="step2Card">
			<div class="card-header bg-info text-white">Step 2: Property Information</div>
			<div class="card-body">
				<form id="step2Form">
					<input type="hidden" name="project_id" id="projectId2">
					<div class="form-row">
						<div class="form-group col-md-3">
							<?= $this->Form->control('district_id', [
								'label' => 'District <span class="required">*</span>',
								'escape' => false,
								'class' => 'form-control',
								'options' => $districts,
								'empty' => 'Select District',
								'required' => true,
								'id' => 'district-id'
							]) ?>
						</div>
						<div class="form-group col-md-3">
							<label>Tehsil/Taluka</label>
							<input type="text" name="tehsil" class="form-control">
						</div>
						<div class="form-group col-md-3">
							<label>Site Location</label>
							<select name="site_location" class="form-control">
								<option value="">Site Location</option>
								<option value="Urban">Urban</option>
								<option value="Rural">Rural</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label>Plot Number</label>
							<input type="text" name="khasra_number" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>City</label>
							<input type="text" name="city" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>Property Number</label>
							<input type="text" name="property_no" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>Property Address</label>
							<input type="text" name="property_address" class="form-control">
						</div>
					</div>

                    <h5 class="mt-4">GIS Coordinates</h5>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label>Latitude *</label>
							<input type="email" name="latitude" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>Longitude *</label>
							<input type="text" name="longitude" class="form-control">
						</div>

					</div>

					<h5 class="mt-4">Personal Details</h5>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label>Email Id of Supervisor/Manager</label>
							<input type="email" name="supervisor_email" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>Mobile Number of Supervisor/Manager</label>
							<input type="text" name="supervisor_mobile" class="form-control">
						</div>
						<div class="form-group col-md-4">
							<label>Name of Supervisor/Manager</label>
							<input type="text" name="supervisor_name" class="form-control">
						</div>
					</div>

					<button type="button" class="btn btn-primary float-right" id="saveStep2">Save & Next</button>
				</form>
			</div>
		</div>

		<!-- STEP 3 -->
		<div class="card mb-4 d-none" id="step3Card">
			<div class="card-header bg-warning text-white">Step 3: Project Details</div>
			<div class="card-body">
				<form id="step3Form">
					<input type="hidden" name="project_id" id="projectId3">
					<div class="form-row">
						<div class="form-group col-md-4">
							<?= $this->Form->control('property_category', [
								'label' => 'Property Category (Labour Cess) *',
								'class' => 'form-control',
								'options' => $propertyCategories
							]) ?>
						</div>
						<div class="form-group col-md-4">
							<?= $this->Form->control('plot_area', ['label' => 'Plot Area (Sqm) *', 'class' => 'form-control']) ?>
						</div>
						<div class="form-group col-md-4">
							<?= $this->Form->control('total_project_cost', ['label' => 'Total Proposed Project Cost (Rs) *', 'class' => 'form-control']) ?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<?= $this->Form->control('construction_area', ['label' => 'Construction Area (Sqm) *', 'class' => 'form-control']) ?>
						</div>
						<div class="form-group col-md-4">
							<?= $this->Form->control('max_labor_count', ['label' => 'Maximum Labour Count per Day *', 'class' => 'form-control']) ?>
						</div>
						<div class="form-group col-md-4">
							<?= $this->Form->control('stage_of_construction', ['label' => 'Stage of Construction *', 'class' => 'form-control']) ?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<?= $this->Form->control('estimated_start_date', ['label' => 'Estimated Start Date *', 'type' => 'date', 'class' => 'form-control']) ?>
						</div>
						<div class="form-group col-md-4">
							<?= $this->Form->control('estimated_end_date', ['label' => 'Estimated End Date *', 'type' => 'date', 'class' => 'form-control']) ?>
						</div>
					</div>

					<button type="button" class="btn btn-primary float-right" id="saveStep3">Save & Next</button>
				</form>
			</div>
		</div>

		<!-- STEP 4 -->
		<div class="card d-none" id="step4Card">
			<div class="card-header bg-success text-white">Step 4: Additional Details</div>
			<div class="card-body">
				<form id="step4Form" enctype="multipart/form-data">
					<input type="hidden" name="project_id" id="projectId4">

					<!-- Labour Section -->
					<div class="card mb-4 shadow-sm">
						<div class="card-header bg-primary text-white"><h5 class="mb-0">Workers Details</h5></div>
						<div class="card-body">
							<div id="labourList">
								<div class="labourRow form-row align-items-center mb-2">
									<div class="col-md-5 mb-2">
										<input type="text" name="labour_cess_labours[0][labour_id]" placeholder="Labour ID" class="form-control">
									</div>
									<div class="col-md-5 mb-2">
										<input type="text" name="labour_cess_labours[0][labour_name]" placeholder="Labour Name" class="form-control">
									</div>
									<div class="col-md-2 text-center mb-2">
										<button type="button" class="btn btn-danger removeLabour w-100">×</button>
									</div>
								</div>
							</div>
							<div class="text-right">
								<button type="button" class="btn btn-outline-primary" id="addLabourBtn"><i class="fa fa-plus"></i> Add More Labour</button>
							</div>
						</div>
					</div>

					<!-- Attachments -->
					<div class="card mb-4 shadow-sm">
						<div class="card-header bg-info text-white"><h5 class="mb-0">Attachments</h5></div>
						<div class="card-body">
							<div class="form-row mb-3">
								<div class="col-md-6">
									<label><strong>Drawing PDF Description</strong></label>
									<textarea name="drawing_pdf_description" class="form-control" rows="3"></textarea>
								</div>
								<div class="col-md-6">
									<label><strong>Drawing PDF File</strong></label>
									<input type="file" name="drawing_pdf_file" accept="application/pdf" class="form-control-file">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label><strong>Estimate of Construction</strong></label>
									<textarea name="sale_deed_description" class="form-control" rows="3"></textarea>
								</div>
								<div class="col-md-6">
									<label><strong>Estimate of Construction File</strong></label>
									<input type="file" name="sale_deed_file" accept="application/pdf" class="form-control-file">
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6">
									<label><strong>List of Workers</strong></label>
									<textarea name="listoflabours_description" class="form-control" rows="3"></textarea>
								</div>
								<div class="col-md-6">
									<label><strong>List of Workers File</strong></label>
									<input type="file" name="listoflabours_file" accept="application/pdf" class="form-control-file">
								</div>
							</div>
                            <div class="form-row">
								<div class="col-md-6">
									<label><strong>Any Other Document</strong></label>
									<textarea name="otherdoc_description" class="form-control" rows="3"></textarea>
								</div>
								<div class="col-md-6">
									<label><strong>Any Other Document File</strong></label>
									<input type="file" name="otherdoc_file" accept="application/pdf" class="form-control-file">
								</div>
							</div>
						</div>
					</div>

					<div class="text-center">
						<button type="button" class="btn btn-success px-5" id="saveStep4">Submit All</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
let labourCount = 1;

// Add/remove labour rows
$('#addLabourBtn').click(() => {
	$('#labourList').append(`
		<div class="labourRow form-row align-items-center mb-2">
			<div class="col-md-5 mb-2">
				<input type="text" name="labour_cess_labours[${labourCount}][labour_id]" placeholder="Labour ID" class="form-control">
			</div>
			<div class="col-md-5 mb-2">
				<input type="text" name="labour_cess_labours[${labourCount}][labour_name]" placeholder="Labour Name" class="form-control">
			</div>
			<div class="col-md-2 text-center mb-2">
				<button type="button" class="btn btn-danger removeLabour w-100">×</button>
			</div>
		</div>
	`);
	labourCount++;
});

$(document).on('click', '.removeLabour', function() {
	$(this).closest('.labourRow').remove();
});

// Smooth scroll
function scrollToCard(step){
	$('html, body').animate({
		scrollTop: $(`#step${step}Card`).offset().top - 60
	}, 600);
}

// Lock form helper
function lockForm(formId) {
	$(`#${formId} input, #${formId} textarea, #${formId} select, #${formId} button`).prop('disabled', true);
	$(`#${formId}`).closest('.card').addClass('locked-card');
}

// Step 1
$('#saveStep1').click(function() {
	$.post('<?php echo webURL;?>/front/saveStep1', $('#step1Form').serialize(), function(res){
		if(res.success){
			localStorage.setItem('project_id', res.project_id);
			$('#projectId2').val(res.project_id);
			lockForm('step1Form');
			$('#step2Card').removeClass('d-none');
			scrollToCard(2);
		}else{
			alert('Failed to save Step 1');
		}
	}, 'json');
});

// Step 2
$('#saveStep2').click(function(){
	$.post('<?php echo webURL;?>/front/saveStep2', $('#step2Form').serialize(), function(res){
		if(res.success){
			$('#projectId3').val(res.project_id);
			lockForm('step2Form');
			$('#step3Card').removeClass('d-none');
			scrollToCard(3);
		}else{
			alert('Failed to save Step 2');
		}
	}, 'json');
});

// Step 3
$('#saveStep3').click(function(){
	$.post('<?php echo webURL;?>/front/saveStep3', $('#step3Form').serialize(), function(res){
		if(res.success){
			$('#projectId4').val(localStorage.getItem('project_id'));
			lockForm('step3Form');
			$('#step4Card').removeClass('d-none');
			scrollToCard(4);
		}else{
			alert('Failed to save Step 3');
		}
	}, 'json');
});

// Step 4
$('#saveStep4').click(function(){
	let fd = new FormData($('#step4Form')[0]);
	$.ajax({
		url: '<?php echo webURL;?>/front/saveStep4',
		type: 'POST',
		data: fd,
		processData: false,
		contentType: false,
		success: function(res){
			if(res.success){
				lockForm('step4Form');
				alert('✅ All steps saved successfully!');
				$('html, body').animate({ scrollTop: 0 }, 800);
				window.location.href = '<?php echo webURL;?>front/task-list';
			}else{
				alert('Failed to save Step 4');
			}
		}
	});
});
</script>