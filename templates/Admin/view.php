<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Labour Cess</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
					<li class="breadcrumb-item active">Labour Cess</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid py-4">
	<div class="card shadow-lg border-0 rounded-4">
		<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
			<h4 class="mb-0">🏗️ Application ID &nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; <?= $project['file_name'] ?></h4>
		</div>
		<div class="card-body">
			<ul class="nav nav-tabs" id="projectTabs" role="tablist">
				<li class="nav-item">
					<button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button">Details</button>
				</li>
				<li class="nav-item">
					<button class="nav-link" id="workflow-tab" data-bs-toggle="tab" data-bs-target="#workflow" type="button">Workflow</button>
				</li>
				<li class="nav-item">
					<button class="nav-link" id="clarification-tab" data-bs-toggle="tab" data-bs-target="#clarification" type="button">Clarification</button>
				</li>
				<li class="nav-item">
					<button class="nav-link" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments" type="button">Attachments</button>
				</li>
				<li class="nav-item">
					<button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button">Payments</button>
				</li>
			</ul>
			<div class="tab-content mt-4">
				<div class="tab-pane fade show active" id="details" role="tabpanel">
					<div class="container-fluid">
						<div class="card shadow-lg border-0 rounded-4">
							<div class="card-header bg-info text-white">
								<h4 class="mb-0">🏗️ Project Information</h4>
							</div>
							<div class="card-body">
								<ul class="nav nav-tabs tab-style2" id="projectTabs" role="tablist">
									<li class="nav-item">
										<button class="nav-link active" id="title-tab" data-bs-toggle="tab" data-bs-target="#title" type="button" role="tab">
											<b>Title</b>
										</button>
									</li>
									<li class="nav-item">
										<button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab">
											<b>Location</b>
										</button>
									</li>
									<li class="nav-item">
										<button class="nav-link" id="org-tab" data-bs-toggle="tab" data-bs-target="#org" type="button" role="tab">
											<b>Organisation</b>
										</button>
									</li>
								</ul>								
								<div class="tab-content mt-4">
									<div class="tab-pane fade show active" id="title" role="tabpanel">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group mb-3">
													<label>Assessment Name</label>
													<span class="form-control"><?= h($project->assessment_name) ?></span>
												</div>
												<div class="form-group mb-3">
													<label>Establishment Type</label>
													<span class="form-control"><?= h($project->establishment_type) ?></span>
												</div>
												<div class="form-group mb-3">
													<label>Description</label>
													<span class="form-control"><?= h($project->description) ?></span>
												</div>
												<div class="form-group mb-3">
													<label>Department</label>
													<span class="form-control"><?= h($project->department->name) ?></span>
												</div>
											</div>
										</div>
										<div class="accordion mt-4" id="projectAccordion">
											<div class="accordion-item">
												<h2 class="accordion-header" id="headingProject">
													<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProject" aria-expanded="true">
														Project Details
													</button>
												</h2>
												<div id="collapseProject" class="accordion-collapse collapse show" data-bs-parent="#projectAccordion">
													<div class="accordion-body">
														<div class="row">
															<div class="form-group col-md-4">
																<label>Construction area (in Sqm)</label>
																<span class="form-control"><?= h($project->construction_area) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Estimated Start Date</label>
																<span class="form-control"><?= h($project->estimated_start_date->format('d-m-Y')) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Estimated End Date</label>
																<span class="form-control"><?= h($project->estimated_end_date->format('d-m-Y')) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Plot Area (in Sqm)</label>
																<span class="form-control"><?= h($project->plot_area) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Max Labour Count</label>
																<span class="form-control"><?= h($project->max_labor_count) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Labour Cess Cost (₹)</label>
																<span class="form-control"><?= h($project->cess_cost) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Property Category</label>
																<span class="form-control"><?= h($project->property_category) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Stage of Construction</label>
																<span class="form-control"><?= h($project->stage_of_construction) ?></span>
															</div>
															<div class="form-group col-md-4">
																<label>Total Project Cost (₹)</label>
																<span class="form-control"><?= h($project->total_project_cost) ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="accordion-item">
												<h2 class="accordion-header" id="headingPersonal">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal">
														Personal
													</button>
												</h2>
												<div id="collapsePersonal" class="accordion-collapse collapse" data-bs-parent="#projectAccordion">
													<div class="accordion-body">
														<div class="row">
															<div class="col-md-4">
																<label>Email ID of Supervisor/Manager</label>
																<span class="form-control"><?= h($project->supervisor_email ?? '') ?></span>
															</div>
															<div class="col-md-4">
																<label>Mobile No. of Supervisor/Manager</label>
																<span class="form-control"><?= h($project->supervisor_mobile ?? '') ?></span>
															</div>
															<div class="col-md-4">
																<label>Name of Supervisor/Manager</label>
																<span class="form-control"><?= h($project->supervisor_name ?? '') ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="accordion-item">
												<h2 class="accordion-header" id="headingGIS">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGIS">
														GIS Coordinates
													</button>
												</h2>
												<div id="collapseGIS" class="accordion-collapse collapse" data-bs-parent="#projectAccordion">
													<div class="accordion-body">
														<div class="row">
															<div class="col-md-4">
																<label>Lattitude</label>
																<span class="form-control"><?= h($project->latitude ?? '-') ?></span>
															</div>
															<div class="col-md-4">
																<label>Longitude</label>
																<span class="form-control"><?= h($project->longitude ?? '-') ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="location" role="tabpanel">
										<div class="card mb-4 shadow-sm">
											<div class="card-header bg-primary text-white">
												<h5 class="mb-0">Site Address</h5>
											</div>
											<div class="card-body">
												<div class="row g-3">
													<div class="col-md-6">
														<label class="form-label small text-muted">Site Address</label>
														<div class="form-control">
															<?= h($project->site_location ?? '-') ?>
														</div>
													</div>
													<div class="col-md-3">
														<label class="form-label small text-muted">Property No / Khasra
														No.</label>
														<div class="form-control">
															<?= h($project->property_no ?? $project->khasra_number ?? '-') ?>
														</div>
													</div>
													<div class="col-md-3">
														<label class="form-label small text-muted">Old Khasra No.</label>
														<div class="form-control"><?= h($project->old_khasra_no ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">Tehsil</label>
														<div class="form-control"><?= h($project->tehsil ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">Tehsil (Other)</label>
														<div class="form-control">
															<?= h($project->tehsil_other ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">District</label>
														<div class="form-control">
															<?= h($project->district->name ?? $project->district->name ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">State</label>
														<div class="form-control"><?= h($project->state ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">City /
														Village</label>
														<div class="form-control"><?= h($project->city ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">City / Village
														(Other)</label>
														<div class="form-control"><?= h($project->city_other ?? '-') ?>
														</div>
													</div>
													<div class="col-md-3">
														<label class="form-label small text-muted">Postal Code</label>
														<div class="form-control">
															<?= h($project->postal_code ?? $project->pincode ?? '-') ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Organisation Tab -->
									<div class="tab-pane fade" id="org" role="tabpanel">
										<!-- Organisation / Contact Details -->
										<div class="card mb-4 shadow-sm">
											<div class="card-header bg-primary text-white">
												<h5 class="mb-0">Organisation & Contact Person Details</h5>
											</div>
											<div class="card-body">
												<div class="row g-3">
													<div class="col-md-6">
														<label class="form-label small text-muted">Organisation</label>
														<div class="form-control">
															<?= h($project->organisation ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">First Name</label>
														<div class="form-control"><?= h($project->first_name ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">Middle Name</label>
														<div class="form-control"><?= h($project->middle_name ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">Last Name</label>
														<div class="form-control"><?= h($project->last_name ?? '-') ?>
														</div>
													</div>
													<div class="col-md-3">
														<label class="form-label small text-muted">Phone (Country
														Code)</label>
														<div class="form-control">
															<?= h($project->country_code ?? '+91') ?>
														</div>
													</div>
													<div class="col-md-3">
														<label class="form-label small text-muted">Phone Number</label>
														<div class="form-control"><?= h($project->mobile ?? '-') ?>
														</div>
													</div>
													<div class="col-md-6">
														<label class="form-label small text-muted">Email ID</label>
														<div class="form-control"><?= h($project->email ?? '-') ?></div>
													</div>
													<div class="col-md-12">
														<label class="form-label small text-muted">Address</label>
														<div class="form-control"><?= h($project->address ?? '-') ?>
														</div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">State</label>
														<div class="form-control"><?= h($project->state ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">City</label>
														<div class="form-control"><?= h($project->city ?? '-') ?></div>
													</div>
													<div class="col-md-4">
														<label class="form-label small text-muted">Postal Code</label>
														<div class="form-control"><?= h($project->postal_code ?? '-') ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="workflow" role="tabpanel">
					<h5 class="fw-bold mb-3">Workflow History</h5>
					<div class="card shadow-sm mt-3">
						<div class="card-body workflow-container">
							<?php foreach ($project_status_flow as $flow) { ?>
								<div class="workflow-item">
									<div class="workflow-icon"></div>
									<div class="workflow-content">
										<h6>Process Name: <strong><?php echo $flow['action_taken'] ?></strong></h6>
										<p class="mb-1 text-muted">
											<i class="bi bi-calendar3"></i> Created Date: <?php echo date('d-M-Y', strtotime($flow['created_at'])) ?>
										</p>
										<p><strong>Remarks / Comment:</strong> <?php echo $flow['remark'] ?></p>
										<p class="text-secondary mb-0">
											<i class="bi bi-people"></i> <?php echo ($flow['username']) ? $flow['username'] :'Applicant' ?>
										</p>
										<?php if ($flow['attachment_file']): ?>
										<p><strong>Attachment:</strong>
											<a href="<?= $this->Url->build('/uploads/flowfiles/'.$flow['attachment_file']) ?>" class="btn btn-sm btn-success me-2" target="_blank">
												<i class="bi bi-eye"></i> View
											</a>
											<a href="<?= $this->Url->build('/uploads/flowfiles/'.$flow['attachment_file']) ?>" class="btn btn-sm btn-warning" download>
												<i class="bi bi-download"></i> Download
											</a>
										</p>
										<?php endif; ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="clarification" role="tabpanel">
					<h5 class="fw-bold mb-3">Objections</h5>
					<?php foreach ($objections as $obj): ?>
						<div class="border p-3 mb-3">
							<?php
								if($obj->flow_id == 4) $obj_title = 'Issue on cess assessment.';
								elseif($obj->flow_id == 5) $obj_title = 'Issue on cess payment.';
							?>
							<h4><?= $obj_title ?>
								<?php if ($obj->status == 2): ?>
									<span class="badge badge-success">Closed</span>
								<?php else: ?>
									<span class="badge badge-warning">Open</span>
								<?php endif; ?>
							</h4>
							<?php if ($obj->status != 2): ?>
								<a href="<?= $this->Url->build([
										'controller' => 'admin',
										'action' => 'closeObjection',
										$obj->id
									]) ?>"
									class="btn btn-sm btn-danger mt-2 mb-2"
									onclick="return confirm('Are you sure you want to close this objection? Once closed, no more comments can be added.');">
									<i class="fa fa-lock"></i> Close Objection
								</a>
							<?php endif; ?>
							<div class="alert alert-warning p-2">
								<strong>Raised by:</strong> <?= h($obj->user->off_name ?? 'Applicant') ?><br>
								<strong>At:</strong> <?= $obj->created_at->format("d-m-Y H:i") ?><br>
								<strong>Remarks:</strong> <?= h($obj->remark) ?><br>
								<strong>Attachment:</strong><br>
								<?php if ($obj->attachment_file): ?>
									<a href="<?= $this->Url->build('/uploads/objections/'.$obj->attachment_file) ?>" class="btn btn-sm btn-success me-2" target="_blank">
										<i class="bi bi-eye"></i> View
									</a>
									<a href="<?= $this->Url->build('/uploads/objections/'.$obj->attachment_file) ?>" class="btn btn-sm btn-warning" download>
										<i class="bi bi-download"></i> Download
									</a>
								<?php endif; ?>
							</div>
							<hr><b>Comments</b>
							<?php foreach ($obj->objection_comments as $c): ?>
								<div class="alert alert-warning ml-3 border-left pl-3">
									<strong>Sent by:</strong> <?= h($c->user->off_name ?? 'Applicant') ?><br>
									<strong>At:</strong> <?= $c->created_at->format("d-m-Y H:i") ?><br>
									<strong>Remarks:</strong> <?= h($c->remark) ?><br>
									<strong>Attachment:</strong><br>
									<?php if ($c->attachment_file): ?>
										<a href="<?= $this->Url->build('/uploads/objections/'.$c->attachment_file) ?>" class="btn btn-sm btn-success me-2" target="_blank">
											<i class="bi bi-eye"></i> View
										</a>
										<a href="<?= $this->Url->build('/uploads/objections/'.$c->attachment_file) ?>" class="btn btn-sm btn-warning" download>
											<i class="bi bi-download"></i> Download
										</a>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
							<?php if ($obj->status != 2): ?>
								<?= $this->Form->create(null, ['type'=>'file', 'url'=>['controller'=>'admin','action'=>'addObjectionComment',$obj->id]]) ?>
									<?= $this->Form->control('remark',['label'=>'Comment/Reply', 'type'=>'textarea', 'rows'=>'4']) ?>
									<?= $this->Form->control('attachment_file',['label'=>'Attachment', 'type'=>'file']) ?>
									<button class="btn btn-sm btn-primary mt-2">Submit</button>
								<?= $this->Form->end() ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="tab-pane fade" id="attachments" role="tabpanel">
					<h5 class="fw-bold mb-3">Attachments</h5>
					<div class="container my-4">
						<div class="accordion" id="attachmentAccordion">
							<div class="accordion" id="projectAccordion">
								<!-- 1. Drawing Pdf -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#headingOne" aria-expanded="false" aria-controls="headingOne">
										1. Drawing Pdf
										</button>
									</h2>
									<div id="headingOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php
												$drawingPdf = null;
												foreach ($project->labour_cess_attachments as $att) {
													if ($att->file_name === 'drawing_pdf_file') {
														$drawingPdf = $att;
														break;
													}
												}
											?>
											<?php if ($drawingPdf): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($drawingPdf->description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $drawingPdf->created_at->format('d-m-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $drawingPdf->file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
														<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $drawingPdf->file_path) ?>" class="btn btn-sm btn-warning" download>
														<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<!-- 2. Estimate Of Construction -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										2. Estimate Of Construction
										</button>
									</h2>
									<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php
												$estimate = null;
												foreach ($project->labour_cess_attachments as $att) {
													if ($att->file_name === 'sale_deed_file') {
														$estimate = $att;
														break;
													}
												}
											?>
											<?php if ($estimate): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($estimate->description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $estimate->created_at->format('d-m-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $estimate->file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $estimate->file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThree">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										3. List of Labours
										</button>
									</h2>
									<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php
												$labours = null;
												foreach ($project->labour_cess_attachments as $att) {
													if ($att->file_name === 'listoflabours_file') {
														$labours = $att;
														break;
													}
												}
												?>
											<?php if ($labours): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($labours->description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $labours->created_at->format('d-m-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $labours->file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $labours->file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<!-- 4. Any Other Attachment -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFour">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										4. Any Attachment
										</button>
									</h2>
									<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php
												$other = null;
												foreach ($project->labour_cess_attachments as $att) {
													if ($att->file_name === 'otherdoc_file') {
														$other = $att;
														break;
													}
												}
											?>
											<?php if ($other): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($other->description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $other->created_at->format('d-m-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $other->file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $other->file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFive">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										5. Proof of Payment (Registration)
										</button>
									</h2>
									<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php if ($regPayment): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($regPayment->attachment_description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $regPayment->created_at->format('d-M-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $regPayment->attachment_file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $regPayment->attachment_file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<!-- 6. Proof of Payment (Cess) -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSix">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
										6. Proof of Payment (Cess)
										</button>
									</h2>
									<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php if ($cessPayment): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($cessPayment->attachment_description) ?></h6>
													<small class="text-muted">Uploaded on: <?= $cessPayment->created_at->format('d-M-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $cessPayment->attachment_file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $cessPayment->attachment_file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<!-- 7. Cess Certificate -->
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSeven">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
										7. Cess Certificate Receipt
										</button>
									</h2>
									<div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#projectAccordion">
										<div class="accordion-body">
											<?php if ($certificate): ?>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<div>
													<h6 class="mb-1 fw-bold"><?= h($certificate->cert_no) ?></h6>
													<small class="text-muted">Uploaded on: <?= $certificate->issue_date->format('d-M-Y') ?></small>
												</div>
												<div>
													<a href="<?= $this->Url->build('/' . $certificate->file_path) ?>" class="btn btn-sm btn-success me-2" target="_blank">
													<i class="bi bi-eye"></i> View
													</a>
													<a href="<?= $this->Url->build('/' . $certificate->file_path) ?>" class="btn btn-sm btn-warning" download>
													<i class="bi bi-download"></i> Download
													</a>
												</div>
											</div>
											<?php else: ?>
											<p class="text-muted">No file uploaded.</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="payment" role="tabpanel">
					<h5 class="fw-bold mb-3">Payment Info</h5>
					<div class="card mt-4 shadow-sm">
						<div class="card-header bg-secondary text-white fw-bold">Registration Charge (Labour Cess)</div>
						<div class="card-body p-0">
							<table class="table mb-0 text-center align-middle">
								<thead class="table-dark">
									<tr>
										<th style="width: 25%;">Fee Description</th>
										<th style="width: 25%;">Note</th>
										<th style="width: 15%;">Date</th>
										<th style="width: 15%;">Fee Amount</th>
										<th style="width: 15%;">Due Amount</th>
										<th style="width: 5%;">Paid</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="d-flex justify-content-center">
												<div class="d-flex">
													<input class="form-check-input me-2" type="checkbox" checked disabled>
													<label class="form-check-label">Registration charge</label>
												</div>
											</div>
										</td>
										<td>Registration Fee</td>
										<td><?= $project->due_date->format('d-m-Y') ?></td>
										<td>₹ 500</td>
										<td>₹ <?= ($project->payment_status == 1) ? 0 : 500 ?></td>
										<td>
											<?php if ($project->payment_status == 1) :?>
											<i class="bi bi-check2 text-success fs-4"></i>
											<?php else: ?>
											<i class="bi bi-x text-danger fs-4"></i>
											<?php endif; ?>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr class="bg-warning text-dark fw-bold">
										<td colspan="3" class="text-end">Total:</td>
										<td>₹ 500</td>
										<td>₹ <?= ($project->payment_status == 1) ? 0 : 500 ?></td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<?php if(in_array($project['flow_id'], [4, 5, 6, 7])){ ?>
					<div class="card mt-4 shadow-sm">
						<div class="card-header bg-secondary text-white fw-bold">Cess Charge (Labour Cess)</div>
						<div class="card-body p-0">
							<table class="table mb-0 text-center align-middle">
								<thead class="table-dark">
									<tr>
										<th style="width: 25%;">Fee Description</th>
										<th style="width: 25%;">Note</th>
										<th style="width: 15%;">Date</th>
										<th style="width: 15%;">Fee Amount</th>
										<th style="width: 15%;">Due Amount</th>
										<th style="width: 5%;">Paid</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="d-flex justify-content-center">
												<div class="d-flex">
													<input class="form-check-input me-2" type="checkbox" checked disabled>
													<label class="form-check-label">Cess charge</label>
												</div>
											</div>
										</td>
										<td>Cess Charges</td>
										<td><?= $project->due_date->format('d-m-Y') ?></td>
										<td>₹ <?= number_format($project['cess_cost'],2) ?></td>
										<td>₹ <?= ($project['cess_pay_status'] == 1) ? 0 : number_format($project['cess_cost'],2) ?></td>
										<td>
											<?php if ($project['cess_pay_status'] == 1) :?>
											<i class="bi bi-check2 text-success fs-4"></i>
											<?php else: ?>
											<i class="bi bi-x text-danger fs-4"></i>
											<?php endif; ?>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr class="bg-warning text-dark fw-bold">
										<td colspan="3" class="text-end">Total:</td>
										<td>₹ <?= number_format($project['cess_cost'],2) ?></td>
										<td>₹ <?= ($project['cess_pay_status'] == 1) ? 0 : number_format($project['cess_cost'],2) ?></td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="objectionModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'admin', 'action' => 'addObjection', base64_encode($project->id)]]) ?>
      <div class="modal-header bg-danger text-white">
        <h5>Raise Objection</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?= $this->Form->control('remark', ['type' => 'textarea', 'rows' => '5', 'label' => 'Remarks', 'required' => true]) ?>
        <?= $this->Form->control('attachment_file', ['type' => 'file', 'label' => 'Attachment (PDF/JPG/PNG)']) ?>
      </div>
      <div class="modal-footer">
        <?= $this->Form->button(__('Submit'), ['class'=>'btn btn-success']) ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<script>
	document.getElementById('assessment_action').addEventListener('change', function() {
		if (this.value === 'objection') {
			$('#objectionModal').modal('show');
		} else{
			$('#objectionModal').modal('hide');
		}
	});
</script>
<!-- Bootstrap JS (Required for Tabs to Work) -->
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') ?>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css') ?>
<style>
	.nav-tabs .nav-link {
	color: #0d6efd;
	font-weight: 500;
	}
	.nav-tabs .nav-link.active {
	background-color: #0d6efd;
	color: white !important;
	border: none;
	}
	/* Timeline Style */
	.workflow-container {
	background-color: #f7faf7;
	position: relative;
	padding: 20px;
	border-left: 4px solid #27ae60;
	}
	.workflow-item {
	position: relative;
	padding-left: 30px;
	margin-bottom: 25px;
	}
	.workflow-item::before {
	content: "";
	position: absolute;
	left: 8px;
	top: 0;
	bottom: 0;
	width: 2px;
	background-color: #27ae60;
	}
	.workflow-icon {
	position: absolute;
	left: -2px;
	top: 8px;
	width: 15px;
	height: 15px;
	background-color: #fff;
	border: 3px solid #27ae60;
	border-radius: 50%;
	z-index: 2;
	}
	.workflow-content {
	background: #f6fbf5;
	padding: 12px 15px;
	border-radius: 6px;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
	}
	.workflow-content h6 {
	font-weight: 600;
	color: #2c3e50;
	}
	.badge.bg-success {
	background-color: #27ae60 !important;
	}
	.nav-tabs .nav-link.active {
	border-color: #27ae60 #27ae60 #fff;
	color: #27ae60;
	}
</style>
</div>
</div>