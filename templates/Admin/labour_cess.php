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
<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center">
		<strong>Task List</strong>
		<div class="d-flex gap-2">
			<select class="form-select form-select-sm" style="width: 160px;">
				<option>Complete</option>
				<option>Pending</option>
			</select>
			<select class="form-select form-select-sm" style="width: 300px;">
				<option>Digital Signature Establishment Registration (LUBR)</option>
			</select>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="task-list-table" class="table table-striped align-middle">
				<thead class="table-success">
					<tr>
						<th>#</th>
						<th>File No.</th>
						<th>Establishment Type</th>
						<th>Assessment Name</th>
						<th>Status</th>
						<th>Due Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<strong>View List</strong>
		<div>
			<button class="btn btn-outline-primary btn-sm">Search</button>
			<button class="btn btn-outline-success btn-sm">Export</button>
		</div>
	</div>
	<div class="card-body">
		<table id="view-list-table" class="table table-hover align-middle">
			<thead class="table-success">
				<tr>
					<th>#</th>
					<th>File No.</th>
					<th>Date</th>
					<th>Assessment Name</th>
					<th>Establishment Type</th>
					<th>Current Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {
		var webURL='<?php echo webURL; ?>';
		$('#task-list-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: webURL+"admin/getlabourData",
				type: "GET"
			}
		});
		$('#view-list-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: webURL+"admin/getViewData",
				type: "GET"
			}
		});
	});
</script>